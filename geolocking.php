<?php
session_start();
$k_head_title = "Master Roles";
$k_page_title = 'Master Roles';
include 'k_files/k_header.php';

$k_head_include = '
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
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

$k_table_title = "Geo Locking";
$k_table_headings = '
<tr>
    <th>Sr No.</th>
    <th>Name</th>
    <th>IP Address</th>
    <th>Group</th>
    <th>Status</th>
    <th>Edit</th>
</tr>';

$sql = "SELECT geoLockings.ID as ID, geoLockings.Name as Name, geoLockings.IPv4Address as IPv4Address, AiGroup.Label as Label, geoLockings.isActive as isActive  FROM geoLockings LEFT JOIN AiGroup ON AiGroup.ID = geoLockings.GroupID WHERE geoLockings.isActive = 1 ORDER BY ID DESC";
$result = db::getInstanceMaster()->db_select($sql);
$k_table_body = "";

if ($result['num_rows'] == 0) {
    $k_table_body .= '<tr><td colspan="5" style="text-align:center;">No data found</td></tr>';
} else {
    for ($i = 0; $i < $result['num_rows']; $i++) {
        $name = $result['result_set'][$i]['Name'];
        $ipv4address = $result['result_set'][$i]['IPv4Address'];
        $group = $result['result_set'][$i]['Label'];
        $isactive = $result['result_set'][$i]['isActive'];
        $srno = $i + 1;
        $k_table_body .= '<tr>
            <td>' . $srno . '</td>
            <td>' . $name . '</td>
            <td>' . $ipv4address . '</td>
            <td>' . $group . '</td>
            <td>' . ($isactive == 1 ? 'Active' : 'Deactive') . '</td>
            <td>
                <form name="form" action="./geoLockingManage.php" method="POST">
                    <input type="hidden" name="editID" value="' . $result['result_set'][$i]['ID'] . '">
                    <button class="btn btn-primary bizbtn" type="submit" title="Edit"><i class="fa fa-pencil"></i></button>
                </form>
            </td>
        </tr>';
    }
}

$k_table_title .= '<a href="geoLockingManage.php" style="float: right;margin-right:60px;">
    <input type="submit" value="Add" class="btn btn-danger" />
</a>';
?>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <!-- Extra Buttons (optional) -->
        </div>
        <h2 class="panel-title"><?php echo $k_table_title; ?></h2>
        <p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped" id="datatable-table">
            <thead>
                <?php echo $k_table_headings; ?>
            </thead>
            <tbody>
                <?php echo $k_table_body; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- DataTables JS and Initialization -->
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
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

<?php
$k_footer_before = '
    <script src="/assets/vendor/select2/js/select2.js"></script>
    <script src="/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
';
include "k_files/k_footer.php";
?>
