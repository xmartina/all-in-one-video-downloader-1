<?php $page_title="View Comments";

include('includes/header.php'); 
include('includes/function.php');
include('language/language.php'); 

$img='assets/images/user_photo.png';

	// Get total comments
function total_comments($post_id)
{
	global $mysqli;

	$query="SELECT COUNT(*) AS total_comments FROM tbl_comments WHERE `post_id`='$post_id'";
	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
	$row=mysqli_fetch_assoc($sql);
	return stripslashes($row['total_comments']);
}

function get_thumb($filename,$thumb_size)
{
	$file_path = getBaseUrl();
	return $thumb_path=$file_path.'thumb.php?src='.$filename.'&size='.$thumb_size;
}

$id=trim($_GET['post_id']);

$sql="SELECT * FROM tbl_video
LEFT JOIN tbl_category
ON tbl_video.`cat_id`=tbl_category.`cid` 
WHERE tbl_video.`status`='1' AND tbl_video.`id`='$id'";

$res=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_assoc($res);

	// Get user view comments
$sql1 ="SELECT tbl_comments.*  FROM tbl_comments
LEFT JOIN tbl_users user ON tbl_comments.`user_id`=user.`id`
WHERE tbl_comments.`post_id` = '$id' AND user.`name`= tbl_comments.`user_name`
ORDER BY tbl_comments.`comment_text` DESC";

$res_comment=mysqli_query($mysqli, $sql1) or die(mysqli_error($mysqli));
$arr_dates=array();
$i=0;
while($comment=mysqli_fetch_assoc($res_comment)){
	$dates=date('d M Y',$comment['dt_rate']);
	$arr_dates[$dates][$i++]=$comment;
}

?>

<div class="app-messaging-container">
	<?php
	if(isset($_SERVER['HTTP_REFERER']))
	{
		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	}
	?>
	<div class="app-messaging" id="collapseMessaging">
		<div class="chat-group">
			<div class="heading" style="font-size: 16px">Video Description</div>
			<ul class="group full-height">
				<li class="message">
					<a href="javascript:void(0)">
						<div class="message">
							<i class="fa fa-tags"></i>
							<div class="content">
								<div class="title">&nbsp;&nbsp;<?=$row['category_name']?></div>
							</div>
						</div>
					</a>
				</li>
				<li class="message">
					<a href="javascript:void(0)">
						<div class="message">
							<i class="fa fa-eye"></i>
							<div class="content">
								<div class="title">&nbsp;&nbsp;<?=$row['totel_viewer']?> Views</div>
							</div>
						</div>
					</a>
				</li>
				<li class="message">
					<a href="javascript:void(0)">
						<div class="message">
							<i class="fa fa-comments-o"></i>
							<div class="content">
								<div class="title">&nbsp;&nbsp;<span class="total_comments"><?=total_comments($id)?></span> Comments</div>
							</div>
						</div>
					</a>
				</li>
			</ul>
		</div>
		<div class="messaging">
			<div class="heading">
				<div class="title" style="font-size: 16px">
					<a class="btn-back" href="manage_comments.php">
						<i class="fa fa-angle-left" aria-hidden="true"></i>
					</a>
					<strong style="font-weight: 600">Title: </strong>&nbsp;&nbsp;<?=$row['video_title']?>
				</div>
				<div class="action"></div>
			</div>
			<ul class="chat" style="flex: unset;height: 500px;">
				<?php 
				if(!empty($arr_dates))
				{
					foreach ($arr_dates as $key => $val) {
						?>
						<li class="line">
							<div class="title"><?=$key?></div>
						</li>
						<?php 
						foreach ($val as $key1 => $value) {

							?>
							<li class="<?=$value['id']?>" style="padding-right: 20px">

								<div class="message" style="padding: 5px 10px 15px 5px;min-height: 60px">
									<img src="<?=$img?>" style="float: left;margin-right: 10px;border-radius: 50%;box-shadow: 0px 0px 2px 1px #ccc;height:50px;width:50px;">
									<span style="color: #000;font-weight: 600"><?=$value['user_name']?></span>
									<br/>
									<span>
										<?=$value['comment_text']?>	
									</span>
								</div>
								<div class="info" style="clear: both;">
									<div class="datetime">
										<?=calculate_time_span($value['dt_rate']);?>
										<a href="javascript:void(0)" class="btn_delete_comment" data-id="<?=$value['id']?>" data-book="<?=$id?>" style="color: red;text-decoration: none;" data-table="tbl_comments"><i class="fa fa-trash"></i> Delete</a>
									</div>
								</div>
							</li>
			<?php } 
			}
		}	
		else{
			?>
			<div class="jumbotron" style="width: 100%; text-align: center;">
				<h3>Sorry !</h3> 
				<p>No comments available</p> 
			</div>
			<?php
		} 
		?>
	</ul>
</div>
</div>
</div>

<?php include('includes/footer.php');?> 

<script type="text/javascript">

// for delets view user comments
$(".btn_delete_comment").click(function(e){
	e.preventDefault();

	var _id=$(this).data("id");

	confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
		init: true,
		dark: false, 
		buttons: duDialog.OK_CANCEL,
		okText: 'Proceed',
		callbacks: {
			okClick: function(e) {
				$(".dlg-actions").find("button").attr("disabled",true);
				$(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
				$.ajax({
					type:'post',
					url:'processData.php',
					dataType:'json',
					data:{id:_id,'action':'removeComment'},
					success:function(res){
						location.reload();
					}
				});
			} 
		}
	});
	confirmDlg.show();
});
</script>