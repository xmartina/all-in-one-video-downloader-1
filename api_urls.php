<?php $page_title="Api Urls";

include("includes/header.php");
include("includes/function.php");

  $file_path = getBaseUrl().'api.php';
  $ios_file_path = getBaseUrl().'ios_api.php';
  
?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
      	<?php
	      	if(isset($_SERVER['HTTP_REFERER']))
	      	{
	      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	      	}
      	 ?>
     	 	<div class="card">
		        <div class="card-header">
		          <?=$page_title?>
		        </div>
       			    <div class="card-body no-padding">
         			 <pre>
                <code class="html">
                <?php 
                  if(file_exists('api.php'))
                  {
                    echo '<br><b>Android API URL</b>&nbsp; '.$file_path;    
                  }
                  
                  if(file_exists('ios_api.php'))
                  {
                    echo '<br><b>iOS API URL</b>&nbsp; '.$ios_file_path;    
                  }
                ?>

                <br><b>Home</b>(Method: get_home_video)
                <br><b>All Videos</b>(Method: get_all_videos)
                <br><b>Latest Videos</b>(Method: get_latest_video)
                <br><b>Category List</b>(Method: get_category)
                <br><b>Videos list by Cat ID</b>(Method: get_vidoe_by_cat_id) (Parameter: cat_id)
                <br><b>Single Video</b>(Method: get_single_video) (Parameter: video_id)
                <br><b>Search Video</b>(Method: get_search_videos) (Parameter: search_text)
                <br><b>User Register</b>(Method: user_register) (Parameter: name, email, password, phone, auth_id, type(Normal, Google, Facebook))
                <br><b>User Login</b>(Method: user_login) (Parameter: email, password, auth_id, type[Normal, Google, Facebook])
                <br><b>User Profile</b>(Method: user_profile) (Parameter: id)
                <br><b>User Profile Update</b>(Method: user_profile_update) (Parameter: user_id, name, email, password, phone)
                <br><b>Forgot Password</b>(Method: forgot_pass) (Parameter: email)
                <br><b>User Status </b>(Method: user_status) (Parameter: user_id)
                <br><b>Comment</b>(Method: video_comment) (Parameter: comment_text, user_name, post_id, user_id)
                <br><b>Report</b>(Method: user_report) (Parameter: post_id, user_id, comment_id(if comment), report)
                <br><b>App Details</b>(Method: get_app_details)
               </code> 
             </pre>
       		</div>
          	</div>
        </div>
	</div>
<br/>
<div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
