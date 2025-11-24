<?php
session_start();
$k_head_title="Master Roles";
$k_page_title ='Master Roles';
include 'k_files/k_header.php';
$k_head_title="Master Roles";
$k_head_include = '
		<link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables/media/css/jquery.dataTables.css" />
		
		<style>
			.multi-check {
				border: 1px solid #cacaca;
				padding: 5px;
				padding-left: 10px;
				max-height: 90px;
				overflow-y: scroll;
			}
			button.btn.btn-danger {
                display: none;
         }
		</style>
';

$viewpage = 1;
$editID = 2;

$k_table_title = "Master Roles";
$k_table_headings = '<tr>
							<th>Sr No.</th>
                            <th>Role Name</th>
                            <th>Edit</th>
					</tr>';

$sql="SELECT * FROM pagerolemaster WHERE GroupID = " . $_SESSION['group_id'] ." AND RoleId != 54";
$result = db::getInstanceMaster()->db_select($sql); 
$k_table_body = "";

if ($result['num_rows'] == 0) {
	$k_table_body .= '<tr><td colspan="3" style="text-align:center;">No data found</td></tr>';
} else {
	for($i = 0; $i < $result['num_rows']; $i++){
		$name= $result['result_set'][$i]['Label']; 
		$srno = $i + 1;
		$k_table_body .= '<tr>
						<td class="action">'.$srno.'</td>
						<td>'.$name.'</td>
						<td><form name="form" action="./page-role-access.php" method="POST">
							<input type="hidden" name="editID" value="'.$result['result_set'][$i]['RoleId'].'">							
							<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="edit"><i class="fa fa-pencil"></i></button>
						</form></td>
					</tr>'; 	
	}
}
$k_table_title .= '<a href="page-role-access.php" style="float: right;margin-right:60px;"><input type="submit" value="Add" class="btn btn-danger" /></a>';
?>

<script type="text/javascript" language="javascript" src="./assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script>
	$(document).ready(function() {
		$('#datatable-table').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"pageLength": 10
		});
	});
</script>

<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<?php 
				$k_table_button_link2 = isset($k_table_button_link2)? $k_table_button_link2 : '#';
				if(isset($k_table_button2)){
					echo "<a href=". $k_table_button_link2 ."><button class='btn btn-danger' name='addnew'>". $k_table_button2 ."</button></a>";
				}
			?>
			<?php 
				$k_table_button_link = isset($k_table_button_link)? $k_table_button_link : '#';
				if(isset($k_table_button)){
					echo "<a href=". $k_table_button_link ."><button class='btn btn-danger' name='addnew'>". $k_table_button ."</button></a>";
				}
			?>
		</div>
		<h2 class="panel-title"><?php echo isset($k_table_title)?$k_table_title : "Table Title"; ?></h2>
		<p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="datatable-table">
			<thead>
				<?php echo isset($k_table_headings)?$k_table_headings:"<tr><th></th></tr>"; ?>
			</thead>
			<tbody>
				<?php echo $k_table_body; ?>
			</tbody>
		</table>
	</div>
</section>

<?php
$k_footer_before = '
	<script src="assets/vendor/select2/js/select2.js"></script>
	<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
';
include "k_files/k_footer.php"; 