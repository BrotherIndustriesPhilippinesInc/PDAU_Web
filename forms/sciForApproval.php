<?php
session_start();
$page = "sciApproval";
$title = 'sciForApproval';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';

include '../global/userInfo.php';
/*include '../process/dashboard_details.php';*/


/*$sql3 = "SELECT MAX(ID)+1 as lastID FROM SCI_Request";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $lastID = $row3['lastID'];
  if ($lastID == null || $lastID == "") {
    $requestID = "REQUEST-SCI-1";
  }
  else{
    $requestID = "REQUEST-SCI-".$lastID;
  }
  
}*/


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
      <h1>For Approval
      </h1>
    </div><!-- End Page Title -->
   
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <form method="POST" action="../process/mainProcess.php?function=batch_approve" id="approvalForm">
              <br>
             <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <div class="col-12 overflow-auto">
              <?php
              if ($accounttype == 'SUPERVISOR') {
                ?>
                <table id="spv_table" class="table table-bordless"  style="font-size:13px;">
                  <thead>
                    <tr>
                      <th scope="col" width="13%">Date</th>
                      <th scope="col" width="10%">RequestID</th>
                      <th scope="col" width="5%">Section</th>
                      <th scope="col" width="7%">Type</th>
                      <th scope="col" width="15%">SCI No</th>
                      <th scope="col" width="25%">Title</th>
                      <th scope="col" width="15%">Model</th>
                      <th scope="col" width="10%">Status/Action</th>
                    </tr>
                  </thead>
                <?php
              }
              else{
                ?>
                <div class="mb-3">
                    <button class="btn btn-success btn-lg" type="button" onclick="approveAll();" ><strong><i class="bi bi-hand-thumbs-up"></i> Approve</strong></button>
                </div>
                
                  <table id="mgr_table" class="table table-bordless"  style="font-size:13px;">
                  <thead>
                    <tr>
                      <th scope="col" width="5%"><label class="prevent-select"><input type="checkbox" name="checkAll" id="checkAll" onclick="toggle(this);" class="form-check-input" style="font-size:18px; margin-top: 0px;"> All</label></th>
                      <th scope="col" width="13%">Date</th>
                      <th scope="col" width="10%">RequestID</th>
                      <th scope="col" width="6%">Section</th>
                      <th scope="col" width="7%">Type</th>
                      <th scope="col" width="13%">SCI No</th>
                      <th scope="col" width="23%">Title</th>
                      <th scope="col" width="13%">Model</th>
                      <th scope="col" width="10%">Status/Action</th>
                    </tr>
                  </thead>
                <?php
              }
              ?>
                  
                    <tbody>
                <?php
                if ($accounttype == 'SUPERVISOR') {
                  $sql = "SELECT * FROM SCI_Request WHERE SPV = '$fullname' AND Status ='SPV APPROVAL' ORDER BY ID DESC";
                }
                elseif($accounttype == 'MANAGER'){
                  $sql = "SELECT * FROM SCI_Request WHERE MGR = '$fullname' AND Status ='MGR APPROVAL' ORDER BY ID DESC";
                }
                else{
                  ?>
                  <script type="text/javascript">
                    alert('Access Denied!');
                    window.location.replace('dashboard-sci.php');
                  </script>
                  <?php
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

                  if ($RequestType == 'NEW') {
                    $SCINo_final = $SCINo;
                  }
                  else{
                    $SCINo_final = $SCINo.'-'.$RevNo;
                  }
                    echo '
                    <tr>';

                    if ($accounttype == 'MANAGER') {
                      echo '<td><input type="checkbox" name="selected[]" id="selected" class="form-check-input checkItem" style="font-size:18px;" value="'.$RequestID.'"></td>';
                    }
                    else{

                    }
                    echo '
                    <td>'.$RequestDate.'</td>
                    <td>'.$RequestID.'</td>
                    <td>'.$RequestSection.'</td>
                    ';
                    if ($RequestType == 'NEW') {
                      echo ' <td class="text-success"><b>'.$RequestType.'</b></td>';
                    }
                    elseif ($RequestType == 'REVISION') {
                      echo ' <td class="text-primary"><b>'.$RequestType.'</b></td>';
                    }
                    else{
                      echo ' <td class="text-warning"><b>'.$RequestType.'</b></td>';
                    }
                    echo '
                    <td>'.$SCINo_final.'</td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    <td> <a href="sciForApproval-details.php?reqID='.$RequestID.'" class="btn btn-sm btn-primary" title="'.$Status.'"><b>'.$Status.'</b></a></td>
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
          </form>

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

  

  </main>


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>

  


 <script type="text/javascript">
  $(document).ready( function () {
    new DataTable('#spv_table', {
      columnDefs: [
      { orderable: false, targets: [0,1,2,3,4,5,6,7] }
      ],
      order: false
    });
  });

    $(document).ready( function () {
    new DataTable('#mgr_table', {
      columnDefs: [
      { orderable: false, targets: [0,1,2,3,4,5,6,7,8] }
      ],
      order: false
    });
  });


  function approveAll(){
    if ($("input[name='selected[]']:checked").length <= 0) {
      setTimeout(function() {
        swal({
          text: 'Please select. Minimum of 1 request.',
          title: "Request Approve", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){

        });
      }, 100);
    }
    else{
      setTimeout(function() {
        swal({
          title: 'Request Approve',
          text: 'Are you sure you want to Approve Request ?',
         imageUrl:'../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: 'green',
          confirmButtonText: 'Yes, approve it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.getElementById("btnLoading").click();
            document.getElementById("approvalForm").submit();

          } else {

          }
        });
      }, 100);
    }
  }


  function toggle(source) {
    var checkboxes = document.querySelectorAll('input[class="form-check-input checkItem"]');
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i] != source)
        checkboxes[i].checked = source.checked;
    }
  }
</script>

</body>

</html>