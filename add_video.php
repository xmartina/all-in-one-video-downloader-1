<?php $page_title = "Add Video";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

$cat_qry = "SELECT * FROM tbl_category ORDER BY `category_name`";
$cat_result = mysqli_query($mysqli, $cat_qry);

$file_path = getBaseUrl();

if (isset($_POST['submit'])) {
  $video_id = '';

  if ($_POST['video_type'] == 'youtube') {

    $video_url = $_POST['video_url'];

    $youtube_video_url = addslashes($_POST['video_url']);
    parse_str(parse_url($youtube_video_url, PHP_URL_QUERY), $array_of_vars);
    $video_id =  $array_of_vars['v'];

    $video_thumbnail = 'https://img.youtube.com/vi/' . $video_id . '/sddefault.jpg';
  } else if ($_POST['video_type'] == 'vimeo') {
    $video_url = $_POST['video_url'];

    $video_id = (int) substr(parse_url($_POST['video_url'], PHP_URL_PATH), 1);

    $get_video_thumb = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));

    $video_thumbnail = $get_video_thumb[0]['thumbnail_large'];
  } else if ($_POST['video_type'] == 'dailymotion') {
    $video_url = $_POST['video_url'];

    $video_id = strtok(basename($_POST['video_url']), '_');

    $video_thumbnail = 'https://www.dailymotion.com/thumbnail/video/' . $video_id;
  } else if ($_POST['video_type'] == 'server_url' or $_POST['video_type'] == 'embeded_code') {
    $video_url = $_POST['video_url'];

    $ext = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);

    $video_thumbnail = rand(0, 99999) . "_video_thumb." . $ext;

    $tpath1 = 'images/' . $video_thumbnail;

    if ($ext != 'png') {
      $pic1 = compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
    } else {
      $tmp = $_FILES['video_thumbnail']['tmp_name'];
      move_uploaded_file($tmp, $tpath1);
    }

    $thumbpath = 'images/thumbs/' . $video_thumbnail;
    $thumb_pic1 = create_thumb_image($tpath1, $thumbpath, '300', '200');

    $video_id = '';
  } else if ($_POST['video_type'] == 'local') {
    $path = "uploads/";

    $video_local = rand(0, 99999) . "_" . str_replace(" ", "-", $_FILES['video_local']['name']);

    $tmp = $_FILES['video_local']['tmp_name'];

    if (move_uploaded_file($tmp, $path . $video_local)) {
      $video_url = $video_local;
    } else {
      echo "Error in uploading video file !!";
      exit;
    }

    $ext = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);

    $video_thumbnail = rand(0, 99999) . "_video_thumb." . $ext;

    $tpath1 = 'images/' . $video_thumbnail;

    if ($ext != 'png') {
      $pic1 = compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
    } else {
      $tmp = $_FILES['video_thumbnail']['tmp_name'];
      move_uploaded_file($tmp, $tpath1);
    }

    //Thumb Image 
    $thumbpath = 'images/thumbs/' . $video_thumbnail;
    $thumb_pic1 = create_thumb_image($tpath1, $thumbpath, '200', '200');
  }

  $data = array(
    'cat_id'  =>  cleanInput($_POST['cat_id']),
    'video_type'  =>  cleanInput($_POST['video_type']),
    'video_title'  =>  cleanInput($_POST['video_title']),
    'video_url'  =>  $video_url,
    'video_id'  =>  $video_id,
    'video_thumbnail'  =>  $video_thumbnail,
    'video_duration'  =>  '-',
    'video_description'  =>  trim($_POST['video_description']),
  );

  $qry = Insert('tbl_video', $data);

  $_SESSION['msg'] = "10";
  $_SESSION['class'] = "success";
  header("Location:manage_videos.php");
  exit;
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="assets/ckeditor/ckeditor.js"></script>
<div class="row">
  <div class="col-md-12">
    <?php
    if (isset($_SERVER['HTTP_REFERER'])) {
      echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
    }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?= $page_title ?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom">
        <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Video Title :-</label>
                <div class="col-md-6">
                  <input type="text" name="video_title" id="video_title" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Category :-</label>
                <div class="col-md-6">
                  <select name="cat_id" id="cat_id" class="select2" required>
                    <option value="">--Select Category--</option>
                    <?php
                    while ($cat_row = mysqli_fetch_array($cat_result)) {
                      ?>
                      <option value="<?php echo $cat_row['cid']; ?>"><?php echo $cat_row['category_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Video Type :-</label>
                <div class="col-md-6">
                  <select name="video_type" id="video_type" style="width:280px; height:25px;" class="select2" required>
                    <option value="">--Select Type--</option>
                    <option value="youtube">Youtube</option>
                    <option value="vimeo">Vimeo</option>
                    <option value="dailymotion">Dailymotion</option>
                    <option value="embeded_code">Embeded Code</option>
                    <option value="server_url">From Server</option>
                    <option value="local">From Local</option>
                  </select>
                </div>
              </div>
              <div id="video_url_display" class="form-group">
                <label class="col-md-3 control-label">Video URL :-</label>
                <div class="col-md-6">
                  <input type="text" name="video_url" id="video_url" value="" class="form-control">
                </div>
              </div>
              <div id="video_local_display" class="form-group" style="display:none;">
                <label class="col-md-3 control-label">Video Upload :-</label>
                <div class="col-md-6">
                  <input type="file" name="video_local" id="video_local" accept="video/*" class="form-control">

                  <div id="uploadPreview" style="display: none;background: #eee;text-align: center;">
                    <video height="400" width="100%" class="video-preview" controls="controls" />
                  </div>
                </div>
              </div><br>
              <div id="thumbnail" class="form-group" style="display:none;">
                <label class="col-md-3 control-label">Thumbnail Image:-
                  <p class="control-label-help">(Recommended resolution: 300*400,400*500 or Rectangle Image)</p>
                </label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" name="video_thumbnail" value="" id="fileupload" accept="image/*">
                    <div class="fileupload_img"><img type="image" src="assets/images/landscape.jpg" alt="image" style="width: 100px;height: 100px;" /></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Video Description :-</label>
                <div class="col-md-6">
                  <textarea name="video_description" id="video_description" class="form-control"></textarea>
                  <script>
                    CKEDITOR.replace('video_description', {
                      filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=&akey=viaviweb',
                      filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=&akey=viaviweb',
                      filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr=&akey=viaviweb'
                    });
                  </script>
                </div>
              </div>
              <br />
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<script type="text/javascript">
  $(document).ready(function(event) {

    $('#video_local').change(function(e) {

      if (isVideo($(this).val())) {
        $('.video-preview').attr('src', URL.createObjectURL(this.files[0]));
        $('#uploadPreview').show();
      } else {
        $('#video_local').val('');
        $('#uploadPreview').hide();
        if ($(this).val() != '')
          alert("Only video files are allowed to upload.")
      }
    });
  });

  function isVideo(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
      case 'm4v':
      case 'avi':
      case 'mp4':
      case 'mov':
      case 'mpg':
      case 'mpeg':
        // etc
        return true;
      }
      return false;
    }

    function getExtension(filename) {
      var parts = filename.split('.');
      return parts[parts.length - 1];
    }

    $("#video_type").change(function() {

      var type = $("#video_type").val();

      if (type == "youtube" || type == "vimeo" || type == "dailymotion") {
      //alert(type);
      $("#video_url_display").show();
      $("#video_local_display").hide();
      $("#thumbnail").hide();
    } else if (type == "server_url" || type == "embeded_code") {
      $("#video_url_display").show();
      $("#thumbnail").show();
      $("#video_local_display").hide();
    } else {
      $("#video_url_display").hide();
      $("#video_local_display").show();
      $("#thumbnail").show();
    }
  });

    $("input[name='video_thumbnail']").change(function() {
      var file = $(this);

      if (file[0].files.length != 0) {
        if (isImage($(this).val())) {
          render_upload_image(this, $(this).next('.fileupload_img').find("img"));
        } else {
          $(this).val('');
          $('.notifyjs-corner').empty();
          $.notify(
            'Only jpg/jpeg, png, gif files are allowed!', {
              position: "top center",
              className: 'error'
            }
            );
        }
      }
    });
  </script>