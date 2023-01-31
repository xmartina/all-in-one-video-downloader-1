<?php 
require("includes/connection.php");
require("includes/function.php");
require("language/language.php");
require("language/app_language.php");

include("smtp_email.php");

$file_path = getBaseUrl();
$response=array();

switch ($_POST['action']) {
	case 'toggle_status':
	$table_nm = $_POST['table'];

	$sql_schema="SHOW COLUMNS FROM $table_nm";
	$res_schema=mysqli_query($mysqli, $sql_schema);
	$row_schema=mysqli_fetch_array($res_schema);

	$id = $_POST['id'];
	$for_action = $_POST['for_action'];
	$column = $_POST['column'];
	$tbl_id = $row_schema[0];

	$message='';

	if ($for_action == 'enable') {
		$data = array($column  =>  '1');
		$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
		$message=$client_lang['13'];
	}else {
		$data = array($column  =>  '0');
		$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
		$message=$client_lang['14'];
	}

	$response['status'] = 1;
	$response['msg'] = $message;
	$response['action'] = $for_action;
	$response['class'] = "success";
	echo json_encode($response);
	break;

	case 'toggle_status_a':
	$id=$_POST['id'];
	$for_action=$_POST['for_action'];
	$column=$_POST['column'];
	$tbl_id=$_POST['tbl_id'];
	$table_nm=$_POST['table'];

	$qry_video="SELECT COUNT(*) as num FROM tbl_video WHERE tbl_video.`featured`= 1";
	$total_video = mysqli_fetch_array(mysqli_query($mysqli,$qry_video));
	$total_video = $total_video['num'];

	if($for_action=='active'){
		if($total_video < 10){
			$data = array($column  =>  '1');
			$edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
			$_SESSION['msg']="13";
			$_SESSION['class']='success';

		}else{
			$_SESSION['class']='error';
			$_SESSION['msg']="19";
		}
	}else{
		$data = array($column  =>  '0');
		$edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
		$_SESSION['msg']="14";
		$_SESSION['class']='success';

	}

	$response['status']=1;
	$response['action']=$for_action;
	echo json_encode($response);
	break;
	
	case 'multi_action':

	$action=$_POST['for_action'];
	$table=$_POST['table'];

	if(is_array($_POST['id']))
		$ids=implode(",", $_POST['id']);
	else
		$ids=$_POST['id'];

	if($action=='enable'){

		$sql="UPDATE $table SET `status`='1' WHERE `id` IN ($ids)";
		mysqli_query($mysqli, $sql);
		$_SESSION['msg']="13";	
		$_SESSION['class']="success";			
	}
	else if($action=='disable'){
		$sql="UPDATE $table SET `status`='0' WHERE `id` IN ($ids)";
		if(mysqli_query($mysqli, $sql)){
			$_SESSION['msg']="14";
			$_SESSION['class']="success";
		}
	}
	else if($action=='delete'){

		if($table=='tbl_users'){

			$deleteSql="DELETE FROM tbl_comments WHERE `user_id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);

			$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);

			$deleteSql="DELETE FROM tbl_rating WHERE `user_id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);

			$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);

			$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);
		}
		else if($table=='tbl_category'){

			$sql="SELECT * FROM tbl_video WHERE `cat_id` IN ($ids)";
			$res=mysqli_query($mysqli, $sql);
			while ($row=mysqli_fetch_assoc($res)){
				if($row['video_thumbnail']!="")
				{
					unlink('images/'.$row['video_thumbnail']);
					unlink('images/thumbs/'.$row['video_thumbnail']);
				}

				if($row['video_type']=="local")
				{
					$file_name=basename($row['video_url']);
					unlink('uploads/'.$file_name);
				}

				Delete('tbl_rating','post_id='.$row['id']);
				Delete('tbl_reports','post_id='.$row['id']);
				Delete('tbl_comments','post_id='.$row['id']);

			}
			$deleteSql="DELETE FROM tbl_video WHERE `cat_id` IN ($ids)";

			mysqli_query($mysqli, $deleteSql);

			mysqli_free_result($res);

			$sqlCategory="SELECT * FROM $table WHERE `cid` IN ($ids)";
			$res=mysqli_query($mysqli, $sqlCategory);
			while ($row=mysqli_fetch_assoc($res)){
				if($row['category_image']!="")
				{
					unlink('images/'.$row['category_image']);
					unlink('images/thumbs/'.$row['category_image']);
				}

			}
			$deleteSql="DELETE FROM $table WHERE `cid` IN ($ids)";

			mysqli_query($mysqli, $deleteSql);
		}
		else if($table=='tbl_video'){

			$sql="SELECT * FROM $table WHERE `id` IN ($ids)";
			$res=mysqli_query($mysqli, $sql);
			while ($row=mysqli_fetch_assoc($res)){
				if($row['video_thumbnail']!="")
				{
					unlink('images/'.$row['video_thumbnail']);
					unlink('images/thumbs/'.$row['video_thumbnail']);
				}

				if($row['video_type']=="local")
				{
					$file_name=basename($row['video_url']);
					unlink('uploads/'.$file_name);
				}

				Delete('tbl_rating','post_id='.$row['id']);
				Delete('tbl_reports','post_id='.$row['id']);
				Delete('tbl_comments','post_id='.$row['id']);

			}
			$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";
			mysqli_query($mysqli, $deleteSql);
		}else if($table=='tbl_comments'){
			$sqlDelete="DELETE FROM tbl_comments WHERE `post_id` IN ($ids)";
			mysqli_query($mysqli, $sqlDelete);
		}else if($table=='tbl_reports'){
			$sqlDelete="DELETE FROM tbl_reports WHERE `post_id` IN ($ids)";
			mysqli_query($mysqli, $sqlDelete);
		}

		$_SESSION['msg']="12";
		$_SESSION['class']="success";
	}

	$response['status']=1;	

	echo json_encode($response);
	break;

	case 'removeComment':
	$id=$_POST['id'];

	$sqlDelete="DELETE FROM tbl_comments WHERE `id`=$id";
	mysqli_query($mysqli, $sqlDelete);
	
	$response['status']=1;	
	$_SESSION['msg']="12";	
	$_SESSION['class']="success";
	echo json_encode($response);
	break;

	case 'removeAllComment':
	$post_id=implode(',', $_POST['ids']);

	$sqlDelete="DELETE FROM tbl_comments WHERE `post_id` IN ($post_id)";

	if(mysqli_query($mysqli, $sqlDelete)){
		$response['status']=1;	
	}
	else{
		$response['status']=0;
	}

	$response['status']=1;
	$_SESSION['msg']="12";	
	$_SESSION['class']="success";	
	echo json_encode($response);
	break;

	case 'removeReport':
	$id=$_POST['post_id'];
	$sqlDelete="DELETE FROM tbl_reports WHERE `id`='$id'";
	mysqli_query($mysqli, $sqlDelete);
	
	$response['status']=1;
	$_SESSION['msg']="12";	
	$_SESSION['class']="success";	
	echo json_encode($response);
	break;

	case 'removeAllRepoert':

	$post_id=implode(',', $_POST['ids']);

	$sqlDelete="DELETE FROM tbl_reports WHERE `post_id` IN ($post_id)";

	if(mysqli_query($mysqli, $sqlDelete)){
		$response['status']=1;	
	}
	else{
		$response['status']=0;
	}

	$response['status']=1;
	$_SESSION['msg']="12";	
	$_SESSION['class']="success";	
	echo json_encode($response);
	break;

	case 'check_smtp':
	{
		$to = trim($_POST['email']);
		$recipient_name='Check User';

		$subject = '[IMPORTANT] '.APP_NAME.' Check SMTP Configuration';

		$message='<div style="background-color: #f9f9f9;" align="center"><br />
		<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		<tbody>
		<tr>
		<td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" /></td>
		</tr>
		<tr>
		<td width="600" valign="top" bgcolor="#FFFFFF"><br>
		<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
		<tbody>
		<tr>
		<td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
		<tbody>
		<tr>
		<td>
		<p style="color: #262626; font-size: 24px; margin-top:0px;">Hi, '.$_SESSION['admin_name'].'</p>
		<p style="color: #262626; font-size: 18px; margin-top:0px;">This is the demo mail to check SMTP Configuration. </p>
		<p style="color:#262626; font-size:17px; line-height:32px;font-weight:500;margin-bottom:30px;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>

		</td>
		</tr>
		</tbody>
		</table></td>
		</tr>

		</tbody>
		</table></td>
		</tr>
		<tr>
		<td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
		</tr>
		</tbody>
		</table>
		</div>';

		send_email($to,$recipient_name,$subject,$message, true);
	}
	break;	

	default:
			# code...
	break;
}
