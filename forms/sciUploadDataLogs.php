<?php
session_start();
$title = 'Upload Data';
$page = 'sci_data';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';

include '../global/userInfo.php';
include '../process/dashboard_details.php';

if ($accounttype != 'ADMIN') {
 header("Location:dashboard-sci.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<style type="text/css">
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 20%;
  }
</style>
<?php include '../global/head.php'; ?>


<body>

 <?php include '../global/header.php'; ?>

  <?php include '../global/sidebar.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>SCI Upload Data (Admin)
      </h1>
    </div><!-- End Page Title -->
   
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
             <!--  <img src="assets/img/underConstruction.png" alt="Profile"  width="1200" height="600"> -->
              <br>
             <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
           <button class="btn btn-danger btn-sm" style="float: right;" data-bs-toggle="modal" data-bs-target="#uploadData"><i class="bi bi-upload"></i> Upload Data</button>
           <br>
           <br>
          <div class="row">
            <div class="col-12 overflow-auto">
                  <table id="uploadDataLogs" class="table table-bordless"  style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col">Date Upload</th>
                        <th scope="col">Upload Code</th>
                        <th scope="col">Section</th>
                        <th scope="col">UploadBy</th>
                        <th scope="col">Status</th>
                        <th scope="col">CancelDate</th>
                        <th scope="col">CancelBy</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                $sql = "SELECT * FROM SCI_UploadDataLogs ORDER BY ID DESC";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $DateUpload = $row['DateUpload'];
                  $UploadCode = $row['UploadCode'];
                  $Section = $row['Section'];
                  $UploadAdmin = $row['UploadAdmin'];
                  $UploadStatus = $row['UploadStatus'];
                  $CancelDate = $row['CancelDate'];
                  $CancelAdmin = $row['CancelAdmin'];

                  if ($UploadStatus == 'Uploaded') {
                   $stat = "<span style='color:green'><b>$UploadStatus</b></span>";
                  }
                  else{
                    $stat = "<span style='color:red'><b>$UploadStatus</b></span>";
                  }
                 
                    echo '
                    <tr>
                    <td>'.$DateUpload.'</td>
                    <td>'.$UploadCode.'</td>
                    <td>'.$Section.'</td>
                    <td>'.$UploadAdmin.'</td>
                    <td>'.$stat.'</td>
                    <td>'.$CancelDate.'</td>
                    <td>'.$CancelAdmin.'</td>
                    <td>
                    ';
                   ?>
                   <?php if ($UploadStatus == 'Uploaded'): ?>
                   <button type="button" class="btn btn-sm btn-danger" onclick="revertUpload();">Revert Upload</button>
                 <?php else: ?>
                  <button type="button" class="btn btn-sm btn-success" onclick="returnUpload();">Return Upload</button>
                   <?php endif ?>
                 </td>
               </tr>
               <?php
             }
             ?>
                  
                    </tbody>

                  </table>


                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
      </div>
    </section>

    <section>
      <div class="modal fade" id="viewDocsLogs" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="displayDocsLogs"></div>
          </div>
        </div>
      </div>
    </section>


  </main>

  <?php
  include '../modal/uploadModal.php';
  ?>


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>



 <script type="text/javascript">

  $(document).ready( function () {

    new DataTable('#uploadDataLogs', {
      initComplete: function () {
        this.api()
        .columns([2,3,4])
        .every(function () {
          let column = this;
          let title = column.header().textContent;

                // Create input element
                let input = document.createElement('input');
                input.style.cssText = 'width:90px;font-size:14px;';
                input.type = 'text';
                input.placeholder = title;
                column.header().replaceChildren(input);

                // Event listener for user input
                input.addEventListener('keyup', () => {
                  if (column.search() !== this.value) {
                    column.search(input.value).draw();
                  }
                });
              });
      },
      columnDefs: [
      { orderable: false, targets: [0,1,2,3,4,5,6,7] }
      ],
      order: [[1, 'asc']]
    });

  } );










    
  </script>

</body>

</html>