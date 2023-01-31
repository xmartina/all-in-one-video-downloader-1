<?php $page_title = "Manage Reports";

include('includes/header.php');
include('includes/function.php');
include('language/language.php');

// Get all report
$sql = "SELECT report.`id`, report.`post_id`,report.`comment_id`, max(report.`report_on`) as report_on FROM tbl_reports report GROUP BY report.`comment_id` ORDER BY report.`id` DESC";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

// Get video info
function get_video_info($post_id)
{
	global $mysqli;

	$query = "SELECT * FROM tbl_video WHERE tbl_video.`id`='" . $post_id . "'";

	$sql = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
	$row = mysqli_fetch_assoc($sql);

	return stripslashes($row['video_title']);
}

// Get total report
function total_reports($post_id)
{
	global $mysqli;

	$query = "SELECT COUNT(*) AS total_reports FROM tbl_reports WHERE `post_id`='$post_id'";
	$sql = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
	$row = mysqli_fetch_assoc($sql);

	return stripslashes($row['total_reports']);
}

function get_comment($comment_id)
{
  global $mysqli;

  $query="SELECT comment_text FROM tbl_comments WHERE `id`='$comment_id'";
  $sql = mysqli_query($mysqli,$query) or die(mysqli_error());
  $row=mysqli_fetch_assoc($sql);

  return stripslashes($row['comment_text']);
}
?>
<style>
	.btn_edit,
	.btn_delete,
	.btn_cust {
		padding: 5px 10px !important;
	}
</style>

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
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12 mrg-top">
				<button class="btn btn-danger btn_cust btn_delete_all" style="margin-bottom:20px;"><i class="fa fa-trash"></i> Delete All</button>
				<table class="datatable table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:40px">
								<div class="checkbox" style="margin: 0px">
									<input type="checkbox" name="checkall" id="checkall_input" value="">
									<label for="checkall_input"></label>
								</div>
							</th>
							<th>Title</th>
							<th>Report Comment</th>
							<th>Total Reports</th>
							<th>Last Report</th>
							<th class="cat_action_list">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						while ($row = mysqli_fetch_array($result)) {
						?>
							<tr>
								<td>
									<div class="checkbox">
										<input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $row['post_id']; ?>" class="post_ids">
										<label for="checkbox<?php echo $i; ?>"></label>
									</div>
								</td>
								<td><?php echo get_video_info($row['post_id']); ?></td>
								<td><?php echo get_comment($row['comment_id']);?> <?php if($row['comment_id']){?>&nbsp;<a href="view_comments.php?post_id=<?=$row['post_id']?>" class="btn btn-success btn_edit" data-toggle="tooltip" data-tooltip="View"><i class="fa fa-info"></i></a> <?php }?></td>
								<td><a href="view_reports.php?post_id=<?= $row['post_id'] ?>&redirect=<?= $redirectUrl ?>"><?= total_reports($row['post_id']) ?> Reports</a></td>
								<td><?= calculate_time_span($row['report_on'], true) ?></td>
								<td>
									<a href="" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete" data-table="tbl_reports" data-id=<?= $row['post_id'] ?>><i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php
							$i++;
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>

<script type="text/javascript">
	// for multiple actions on report
	$(".btn_delete_all").click(function(e) {
		e.preventDefault();

		var _ids = $.map($('.post_ids:checked'), function(c) {
			return c.value;
		});
		var _action = $(this).data("action");

		if (_ids != '') {
			confirmDlg = duDialog('Action: ' + $(this).text(), 'Do you really want to perform?', {
				init: true,
				dark: false,
				buttons: duDialog.OK_CANCEL,
				okText: 'Proceed',
				callbacks: {
					okClick: function(e) {
						$(".dlg-actions").find("button").attr("disabled", true);
						$(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
						var _table = 'tbl_reports';

						$.ajax({
							type: 'post',
							url: 'processData.php',
							dataType: 'json',
							data: {
								ids: _ids,
								'action': 'removeAllRepoert'
							},
							success: function(res) {
								$('.notifyjs-corner').empty();
								if (res.status == '1') {
									location.reload();
								}
							}
						});

					}
				}
			});
			confirmDlg.show();
		} else {
			infoDlg = duDialog('Opps!', 'No data selected', {
				init: true
			});
			infoDlg.show();
		}
	});

	// Checkall input
	var totalItems = 0;

	{
		$("#checkall_input").click(function() {

			totalItems = 0;

			$("input[name='post_ids[]']").prop('checked', this.checked);

			$.each($("input[name='post_ids[]']:checked"), function() {
				totalItems = totalItems + 1;
			});


			if ($("input[name='post_ids[]']").prop("checked") == true) {
				$('.notifyjs-corner').empty();
				$.notify(
					'Total ' + totalItems + ' item checked', {
						position: "top center",
						className: 'success'
					}
				);
			} else if ($("input[name='post_ids[]']").prop("checked") == false) {
				totalItems = 0;
				$('.notifyjs-corner').empty();
			}
		});

		var noteOption = {
			clickToHide: false,
			autoHide: false,
		}

		$.notify.defaults(noteOption);

		$(".post_ids").click(function(e) {

			if ($(this).prop("checked") == true) {
				totalItems = totalItems + 1;
			} else if ($(this).prop("checked") == false) {
				totalItems = totalItems - 1;
			}

			if (totalItems == 0) {
				$('.notifyjs-corner').empty();
				exit;
			}

			$('.notifyjs-corner').empty();

			$.notify(
				'Total ' + totalItems + ' item checked', {
					position: "top center",
					className: 'success'
				}
			);
		});
	}
</script>