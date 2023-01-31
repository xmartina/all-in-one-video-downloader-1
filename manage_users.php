<?php $page_title = "Manage Users";

include('includes/header.php');
require('language/language.php');
require("includes/function.php");

// Get users
$tableName = "tbl_users";
$targetpage = "manage_users.php";
$limit = 10;

$keyword = '';

if (!isset($_GET['keyword'])) {
  $query = "SELECT COUNT(*) as num FROM $tableName";
} else {

  $keyword = addslashes(trim($_GET['keyword']));

  $query = "SELECT COUNT(*) as num FROM $tableName WHERE (`name` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `phone` LIKE '%$keyword%') AND id <> 0";

  $targetpage = "manage_users.php?keyword=" . $_GET['keyword'];
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

if (!isset($_GET['keyword'])) {
  $sql_query = "SELECT * FROM tbl_users WHERE  id <> 0 ORDER BY tbl_users.`id` DESC LIMIT $start, $limit";
} else {

  $sql_query = "SELECT * FROM tbl_users WHERE (`name` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `phone` LIKE '%$keyword%') AND  id <> 0 ORDER BY tbl_users.`id` DESC LIMIT $start, $limit";
}

$result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));


function highlightWords($text, $word)
{
  $text = preg_replace('#' . preg_quote($word) . '#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
  return $text;
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
              <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php if (isset($_POST['keyword'])) {
                  echo $_POST['keyword'];
                } ?>" required>
                <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="add_btn_primary"> <a href="add_user.php?add">Add User</a> </div>
          </div>
        </div>
        <div class="col-md-4 col-xs-12 text-right" style="float: right;">
          <div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
            <input type="checkbox" id="checkall_input">
            <label for="checkall_input">
              Select All
            </label>
          </div>
          <div class="dropdown" style="float:right">
            <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
              <span class="caret"></span></button>
              <ul class="dropdown-menu" style="right:0;left:auto;">
                <li><a href="" class="actions" data-action="enable" data-table="tbl_users">Enable</a></li>
                <li><a href="" class="actions" data-action="disable" data-table="tbl_users">Disable</a></li>
                <li><a href="" class="actions" data-action="delete" data-table="tbl_users">Delete !</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 mrg-top">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>User Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th class="cat_action_list" style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while ($users_row = mysqli_fetch_array($result)) { ?>
                <tr>
                  <td nowrap="">
                    <div class="checkbox" style="margin: 0px;float: left;">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $users_row['id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i; ?>">
                      </label>
                    </div>
                  </td>
                  <td><?php echo $users_row['user_type']; ?></td>
                  <td><?php echo $users_row['name']; ?></td>
                  <td><?php echo $users_row['email']; ?></td>
                  <td><?php echo $users_row['phone']; ?></td>
                  <td>

                    <div class="row toggle_btn">
                      <input type="checkbox" id="enable_disable_check_<?= $i ?>" data-id="<?= $users_row['id'] ?>" data-table="tbl_users" data-column="status" class="cbx hidden enable_disable" <?php if ($users_row['status'] == 1) {
                        echo 'checked';
                      } ?>>
                      <label for="enable_disable_check_<?= $i ?>" class="lbl"></label>
                    </div>
                  </td>
                  <td>
                    <a href="add_user.php?user_id=<?php echo $users_row['id']; ?>&redirect=<?= $redirectUrl ?>" class="btn btn-primary btn_cust" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn_delete btn_cust" data-table="tbl_users" data-id="<?php echo $users_row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php $i++;
              } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-12 col-xs-12">
          <div class="pagination_item_block">
            <nav>
              <?php if (!isset($_POST["user_search"])) {
                include("pagination.php");
              } ?>
            </nav>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <?php include('includes/footer.php'); ?>