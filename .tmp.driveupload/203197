<!DOCTYPE html>
<html>
  <head>
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

  </head>
  <style>
    table, th, td {
      border:1px solid black;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
      padding: 2px;
      line-height: 1.2;
      vertical-align: top;
      border-top: 1px solid #ddd;
      font-size: 12px;
    }
  </style>
  <body>
  <section class="body-sign">
      <div class="panel-body">
        <form action="rptFileUploader.php" method="post" enctype="multipart/form-data">
          
          <div class="row">
            <div class="form-group col-md-4">
              <label>Select rpt file to upload *</label>
              <input type="file" required class="form-control" name="fileToUpload" id="fileToUpload" accept=".rpt" />
            </div>
            <br>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary">Upload</button>
              <a href="rptUploader.php" class="btn btn-secondary">CLEAR</a>
            </div>
          </div>
          <br>
          <?php
            session_start();
            if (!empty($_SESSION['message'])) {
                echo '<p class="message" style="color:red;"> '.$_SESSION['message'].'</p>';
                unset($_SESSION['message']);
            }
          ?>
        </form>
        <br><br>
        <table class="table" style="width:50%;">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>File Name</th>
                <th>Modified</th>
                <th>Download RPT</th>
                <!-- <th>Delete RPT</th> -->
              </tr>
          </thead>
          <tbody>
            <?php 
              if(count(glob('reports/*.rpt*')) > 0){
                $files = (glob('reports/*.rpt*'));
                usort( $files, function( $a, $b ) { return filemtime($b) - filemtime($a); } );
                $counter = 0;
                foreach($files as $filename){
            ?>
                <tr>
                  <td><?php echo ++$counter; ?></td>
                  <td><?php echo basename($filename); ?></td>
                  <td><?php echo date("Y-m-d H:i:s",filemtime($filename)); ?></td>
                  <td><a href='reports/<?php echo basename($filename); ?>'>Download</a></td>
                  <!-- <td><a href='rptUploaderDelete.php?file=<?php echo basename($filename); ?>'>Delete</a></td> -->
                </tr>
            <?php
                }
              }else{
            ?>
                  <tr><td colspan="4"><center>No record found</center></td></tr>

            <?php
              }
            ?>
          </tbody>
        

        </table>
      </div>
  </section>
  </body>
</html>