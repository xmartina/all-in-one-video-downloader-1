<?php $page_title = "Manage Videos";

include("includes/header.php");
require("includes/connection.php");
require("includes/function.php");
require("language/language.php");

$tableName = "tbl_video";
$limit = 12;

// Filter
if (isset($_GET['filter'])) {
  if ($_GET['filter'] == 'enable') {
    $status = "tbl_video.`status`='1'";
  } else if ($_GET['filter'] == 'disable') {
    $status = "tbl_video.`status`='0'";
  } else if ($_GET['filter'] == 'slider') {
    $status = "tbl_video.`featured`='1'";
  } else if ($_GET['filter'] == 'no_slider') {
    $status = "tbl_video.`featured`='0'";
  }
}

// Filter category
if (isset($_GET['cat_id'])) {

  $cat_id = filter_var($_GET['cat_id'], FILTER_SANITIZE_STRING);

  if (isset($_GET['filter'])) {

    $query = "SELECT COUNT(*) as num FROM tbl_video 
		LEFT JOIN tbl_category ON tbl_video.`cat_id`=tbl_category.`cid`
		WHERE $status AND " . $_GET['filter'] . "";

    $targetpage = "manage_videos.php?cat_id=$cat_id&filter=" . $_GET['filter'];
  } else {
    $query = "SELECT COUNT(*) as num FROM $tableName WHERE `cat_id`='$cat_id'";

    $targetpage = "manage_videos.php?cat_id=" . $cat_id;
  }

  $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
  $total_pages = $total_pages['num'];

  $stages = 3;
  $page = 0;
  if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($mysqli, $_GET['page']);
  }
  if ($page) {
    $start = ($page - 1) * $limit;
  } else {
    $start = 0;
  }

  $query = "SELECT tbl_category.`category_name`,tbl_video.* FROM tbl_video
	LEFT JOIN tbl_category ON tbl_video.`cat_id`= tbl_category.`cid` 
	WHERE tbl_video.`cat_id`='$cat_id'
	ORDER BY tbl_video.`id` DESC LIMIT $start, $limit";

  $result = mysqli_query($mysqli, $query);

  if (isset($_GET['filter'])) {

    $status = '';

    if ($_GET['filter'] == 'enable') {
      $status = "tbl_video.`status`='1'";
    } else if ($_GET['filter'] == 'disable') {
      $status = "tbl_video.`status`='0'";
    } else if ($_GET['filter'] == 'slider') {
      $status = "tbl_video.`featured`='1'";
    } else if ($_GET['filter'] == 'no_slider') {
      $status = "tbl_video.`featured`='0'";
    }

    $query = "SELECT tbl_category.`category_name`,tbl_video.* FROM tbl_video
		LEFT JOIN tbl_category ON tbl_video.`cat_id`=tbl_category.`cid`
		WHERE $status AND tbl_video.`cat_id`='$cat_id'
		ORDER BY tbl_video.`id` DESC LIMIT $start, $limit";

    $result = mysqli_query($mysqli, $query);
  }
} else if (isset($_GET['filter'])) {


  $targetpage = "manage_videos.php?filter=" . $_GET['filter'];
  $status = '';

  if ($_GET['filter'] == 'enable') {
    $status = "tbl_video.`status`='1'";
  } else if ($_GET['filter'] == 'disable') {
    $status = "tbl_video.`status`='0'";
  } else if ($_GET['filter'] == 'slider') {
    $status = "tbl_video.`featured`='1'";
  } else if ($_GET['filter'] == 'no_slider') {
    $status = "tbl_video.`featured`='0'";
  }

  $query = "SELECT COUNT(*) as num FROM tbl_video 
	LEFT JOIN tbl_category ON tbl_video.`cat_id`=tbl_category.`cid`
	WHERE $status";
  $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
  $total_pages = $total_pages['num'];

  $stages = 3;
  $page = 0;
  if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($mysqli, $_GET['page']);
  }
  if ($page) {
    $start = ($page - 1) * $limit;
  } else {
    $start = 0;
  }

  $query = "SELECT tbl_category.`category_name`,tbl_video.* FROM tbl_video
	LEFT JOIN tbl_category ON tbl_video.`cat_id`=tbl_category.`cid`
	WHERE $status
	ORDER BY tbl_video.`id` DESC LIMIT $start, $limit";

  $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
}

//Get search videos 
else if (isset($_POST['data_search'])) {

  $keyword = filter_var($_POST['search_value'], FILTER_SANITIZE_STRING);

  $query = "SELECT tbl_video.*,tbl_category.`category_name` FROM tbl_video
	LEFT JOIN tbl_category ON tbl_video.`cat_id` = tbl_category.`cid` WHERE tbl_video.`video_title` LIKE '%$keyword%' ORDER BY tbl_video.`id` DESC";

  $result = mysqli_query($mysqli, $query);
} else {

  $targetpage = "manage_videos.php";
  $query = "SELECT COUNT(*) as num FROM $tableName";
  $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
  $total_pages = $total_pages['num'];

  $stages = 3;
  $page = 0;
  if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($mysqli, $_GET['page']);
  }
  if ($page) {
    $start = ($page - 1) * $limit;
  } else {
    $start = 0;
  }

  $query = "SELECT tbl_category.`category_name`,tbl_video.* FROM tbl_video
	LEFT JOIN tbl_category ON tbl_video.`cat_id`= tbl_category.`cid` 
	ORDER BY tbl_video.`id` DESC LIMIT $start, $limit";

  $result = mysqli_query($mysqli, $query);
}

?>
<div class="row">
  <div class="col-xs-12">
    <?php
    if (isset($_SERVER['HTTP_REFERER'])) {
      echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
    }
    ?>
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?= $page_title ?></div>
        </div>
        <div class="col-md-7 col-xs-12">
          <div class="search_list">
            <div class="search_block">
              <form method="post" action="">
                <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" value="<?= (isset($_POST['search_value']) ? $search : '') ?>" name="search_value" required>
                <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="add_btn_primary"> <a href="add_video.php">Add Video</a> </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <form id="filterForm" accept="" method="GET">
          <div class="col-md-3">
            <select name="filter" class="form-control select2 filter" required style="padding: 5px 30px;height: 40px;">
              <option value="">All</option>
              <option value="enable" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'enable') {
                                        echo 'selected';
                                      } ?>>Enable</option>
              <option value="disable" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'disable') {
                                        echo 'selected';
                                      } ?>>Disable</option>
              <option value="slider" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'slider') {
                                        echo 'selected';
                                      } ?>>Featured</option>
              <option value="no_slider" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'no_slider') {
                                          echo 'selected';
                                        } ?>>No Featured</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="cat_id" class="form-control select2 filter" required style="padding: 5px 40px;height: 40px;">
              <option value="">All Category</option>
              <?php
              $cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
              $cat_result = mysqli_query($mysqli, $cat_qry);
              while ($cat_row = mysqli_fetch_array($cat_result)) {
              ?>
                <option value="<?php echo $cat_row['cid']; ?>" <?php if (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_row['cid']) {
                                                                  echo 'selected';
                                                                } ?>><?php echo $cat_row['category_name']; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </form>
        <div class="col-md-4 col-xs-12 text-right" style="float: right;">
          <div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
            <input type="checkbox" id="checkall_input">
            <label for="checkall_input">
              Select All
            </label>
          </div>
          <div class="dropdown" style="float:right">
            <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" style="right:0;left:auto;">
              <li><a href="" class="actions" data-action="enable" data-table="tbl_video">Enable</a></li>
              <li><a href="" class="actions" data-action="disable" data-table="tbl_video">Disable</a></li>
              <li><a href="" class="actions" data-action="delete" data-table="tbl_video">Delete !</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <div class="row">
          <?php
          $i = 0;
          while ($row = mysqli_fetch_array($result)) {
            $video_file = $row['video_url'];

            if ($row['video_type'] == 'local') {
              $video_file = $file_path . 'uploads/' . basename($row['video_url']);
            } else if ($row['video_type'] == 'youtube') {
              $video_file = 'https://www.youtube.com/embed/' . $row['video_id'];
            } else if ($row['video_type'] == 'dailymotion') {
              $video_file = 'https://www.dailymotion.com/embed/video/' . $row['video_id'];
            } else if ($row['video_type'] == 'vimeo') {
              $video_file = 'https://player.vimeo.com/video/' . $row['video_id'];
            }

          ?>
            <div class="col-lg-4 col-sm-6 col-xs-12">
              <div class="block_wallpaper">
                <div class="wall_category_block">
                  <h2><?php echo $row['category_name']; ?></h2>

                  <?php if ($row['featured'] != "0") { ?>
                    <a class="toggle_btn_a" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="deactive" data-column="featured" data-toggle="tooltip" data-tooltip="Featured">
                      <div style="color:green;"><i class="fa fa-check-circle"></i></div>
                    </a>
                  <?php } else { ?>
                    <a class="toggle_btn_a" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-action="active" data-column="featured" data-toggle="tooltip" data-tooltip="Set Featured"><i class="fa fa-circle"></i></a>
                  <?php } ?>

                  <div class="checkbox" style="float: right">
                    <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $row['id']; ?>" class="post_ids" style="margin: 0px;">
                    <label for="checkbox<?php echo $i; ?>"></label>
                  </div>

                </div>
                <div class="wall_image_title">
                  <p><?php echo $row['video_title']; ?></p>
                  <ul>

                    <li><a href="" class="btn_preview" data-type="<?= $row['video_type'] ?>" data-title="<?= $row['video_title'] ?>" data-url="<?= htmlentities($video_file) ?>" data-toggle="tooltip" data-tooltip="Video Preview"><i class="fa fa-video-camera"></i></a></li>

                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['totel_viewer']; ?> Views"><i class="fa fa-eye"></i></a></li>

                    <li><a href="edit_video.php?video_id=<?php echo $row['id']; ?>&redirect=<?= $redirectUrl ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>

                    <li>
                      <a href="javascript:void(0)" class="btn_delete" data-table="tbl_video" data-id="<?php echo $row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                    </li>

                    <li>
                      <div class="row toggle_btn">
                        <input type="checkbox" id="enable_disable_check_<?= $i ?>" data-id="<?= $row['id'] ?>" data-table="tbl_video" data-column="status" class="cbx hidden enable_disable" <?php if ($row['status'] == 1) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                              } ?>>
                        <label for="enable_disable_check_<?= $i ?>" class="lbl"></label>
                      </div>
                    </li>

                  </ul>
                </div>

                <span>
                  <?php
                  if (($row['video_type'] == "server_url" || $row['video_type'] == 'embeded_code' || $row['video_type'] == 'local') && $row['video_thumbnail'] != '') {
                    echo '<img src="images/' . $row['video_thumbnail'] . '" /> ';
                  } else if (($row['video_type'] != "server_url" || $row['video_type'] != 'embeded_code' || $row['video_type'] != 'local') && $row['video_thumbnail'] != '') {
                    echo '<img src="' . $row['video_thumbnail'] . '" /> ';
                  } else {
                    echo '<img src="images/default_img.jpg" />';
                  }
                  ?>
                </span>

              </div>
            </div>
          <?php
            $i++;
          }
          ?>
        </div>
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="pagination_item_block">
          <nav>
            <?php if (!isset($_POST["data_search"])) {
              include("pagination.php");
            } ?>
          </nav>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>


<style type="text/css">
  iframe body {
    text-align: center !important;

  }

  iframe {
    min-height: 500px !important;
  }
</style>

<!-- Video Preview Modal -->
<div id="videoPreview" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding-top: 15px;padding-bottom: 15px;background: rgba(0,0,0.05);border-bottom-width: 0px;">
        <button type="button" class="close" data-dismiss="modal" style="color: #fff;font-size: 35px;font-weight: normal;opacity: 1">&times;</button>
        <h4 class="modal-title" style="color: #fff"></h4>
      </div>
      <div class="modal-body" style="padding: 0px;background: #000">
        <iframe width="100%" height="500" style="border:0" src=""></iframe>
      </div>
    </div>

  </div>
</div>

<?php include("includes/footer.php"); ?>

<script type="text/javascript">
  // video prview 
  $('#videoPreview').on('hidden.bs.modal', function() {
    $("#videoPreview iframe").removeAttr("src");
  });

  $(".btn_preview").on("click", function(e) {
    e.preventDefault();
    $("#videoPreview .modal-title").text($(this).data("title"));
    if ($(this).data("type") != 'embeded_code') {
      $("#videoPreview iframe").attr('src', $(this).data("url"));
    } else {
      $("#videoPreview .modal-body").html($(this).data("url"));
    }
    $("#videoPreview").modal("show");
  });

  $(".filter").on("change", function(e) {
    $("#filterForm *").filter(":input").each(function() {
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });
</script>