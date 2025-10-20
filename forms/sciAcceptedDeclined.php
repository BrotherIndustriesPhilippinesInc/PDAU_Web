<?php
session_start();
$title = 'sciHistory';
$page = 'sci';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';

include '../global/userInfo.php';
include '../process/dashboard_details.php';

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

   <?php include_once '../global/session_validator.php';?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Approved / Cancelled
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
          <div class="row">
            <div class="col-12 overflow-auto">
                  <table id="example" class="table table-bordless" name="tblApproveReject" style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col" hidden>ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">RequestID</th>
                        <th scope="col">Type</th>
                        <th scope="col">SCI No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Model</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                if ($section == 'Common') {
                  $sql = "SELECT * FROM SCI_Request WHERE Status = 'APPROVED' OR Status = 'CANCELLED' ORDER BY ID DESC";
                }
                else{
                  $sql = "SELECT * FROM SCI_Request WHERE (Status = 'APPROVED' OR Status = 'CANCELLED') AND Requestor = '$fullname' ORDER BY ID DESC";
                }
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $RequestDate = $row['RequestDate'];
                  $RequestID = $row['RequestID'];
                  $RequestType = $row['RequestType'];
                  $SCINo = $row['SCINo'];
                  $RevNo = $row['RevNo'];
                  $Title = $row['Title'];
                  $Model = $row['Model'];
                  $SPV = $row['SPV'];
                  $MGR = $row['MGR'];
                  $Validity = $row['Validity'];
                  $ValidityDate = $row['ValidityDate'];
                  $RequestDetails = $row['RequestDetails'];
                  $Requestor = $row['Requestor'];
                  $RequestSection = $row['RequestSection'];
                  $SCIExcel = $row['SCIExcel'];
                  $SCIPDF = $row['SCIPDF'];
                  $SCIForProcess = $row['SCIForProcess'];
                  $Status = $row['Status'];
                  $Location = $row['Location'];

                  if ($RequestType == 'NEW') {
                    $SCINo_final = $SCINo;
                  }
                  else{
                    $SCINo_final = $SCINo.'-'.$RevNo;
                  }
                    echo '
                    <tr>
                    <td hidden>'.$id.'</td>
                    <td>'.$RequestDate.'</td>
                    <td>'.$RequestID.'</td>
                    <td><b>'.$RequestType.'</b></td>
                    <td>'.$SCINo_final.'</td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    ';
                   if ($Status == 'APPROVED') {
                    echo '<td> <a class="btn btn-sm btn-success openApprovalStatus" title="'.$Status.'" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewApprovalStatus"><b>'.$Status.'</b></a>';                   
                   }
                    else {
                      echo '<td>
                       <a class="btn btn-sm btn-warning openCancelled" title="'.$Status.'" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewCancelled"><b>'.$Status.'</b></a>
                      </td>
                       ';
                    }
                    echo '
                    <td> <a class="openSCILogs" title="Request Logs" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewSCILogs"><img src="../assets/img/log.png" width="25px;"></a></td>
                   ';
                  
                   ?>
                   
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
      <div class="modal fade" id="viewApprovalStatus" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="displayApprovalStatus"></div>
         </div>
       </div>
     </div>
    </section>


    <section>
      <div class="modal fade" id="viewSCILogs" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="displaySCILogs"></div>
         </div>
       </div>
     </div>
   </section>


   <section>
    <div class="modal fade" id="viewRejected" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="displayRejected"></div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="modal fade" id="viewCancelled" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="displayCancelled"></div>
        </div>
      </div>
    </div>
  </section>

  

  </main>


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>


 <script type="text/javascript">

    $(document).ready( function () {

      new DataTable('#example', {
      order: [[0, 'asc']],
        columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7] }
        ],
        
      });


} );
  </script>

</body>

</html>