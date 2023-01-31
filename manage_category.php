<?php $page_title = "Manage Categories";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

// Search category
if (isset($_POST['data_search'])) {

  $keyword = filter_var($_POST['search_value'], FILTER_SANITIZE_STRING);

  $qry = "SELECT * FROM tbl_category WHERE tbl_category.`category_name` LIKE '%$keyword%'
  ORDER BY tbl_category.`category_name`";

  $result = mysqli_query($mysqli, $qry);
} else {

  //Get all Category 
  $tableName = "tbl_category";
  $targetpage = "manage_category.php";
  $limit = 12;

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

  $qry = "SELECT * FROM tbl_category
  ORDER BY tbl_category.`cid` DESC LIMIT $start, $limit";

  $result = mysqli_query($mysqli, $qry);
}

// Get total item 
function get_total_item($cat_id)
{
  global $mysqli;

  $qry_songs = "SELECT COUNT(*) as num FROM tbl_video WHERE `cat_id`='" . $cat_id . "'";

  $total_songs = mysqli_fetch_array(mysqli_query($mysqli, $qry_songs));
  $total_songs = $total_songs['num'];

  return $total_songs;
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
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="add_btn_primary"> <a href="add_category.php?add=yes">Add Category</a> </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <div class="row">
          <?php
          $i = 0;
          while ($row = mysqli_fetch_array($result)) { ?>
            <div class="col-lg-3 col-sm-6 col-xs-12">
              <div class="block_wallpaper add_wall_category">
                <div class="wall_image_title">
                  <h2><a href="javascript:void(0)"><?php echo $row['category_name']; ?> <span>(<?php echo get_total_item($row['cid']); ?>)</span></a></h2>
                  <ul>

                    <li><a href="add_category.php?cat_id=<?php echo $row['cid']; ?>&redirect=<?= $redirectUrl ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                    <li>
                      <a href="javascript:void(0)" class="btn_delete" data-table="tbl_category" data-id="<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                    </li>
                    <li>
                      <div class="row toggle_btn">
                        <input type="checkbox" id="enable_disable_check_<?= $i ?>" data-id="<?= $row['cid'] ?>" data-table="tbl_category" data-column="status" class="cbx hidden enable_disable" <?php if ($row['status'] == 1) {
                          echo 'checked';
                        } ?>>
                        <label for="enable_disable_check_<?= $i ?>" class="lbl"></label>
                      </div>
                    </li>

                  </ul>
                </div>
                <span><img src="images/<?php echo $row['category_image']; ?>" /></span>
              </div>
            </div>

            <?php $i++;
          } ?>

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

<?php include("includes/footer.php"); ?>