<?php
session_start();
$title = 'processCheck';
$page = 'processChecking';
$reqID = $_GET['reqID'];


include '../global/conn.php';
$sql = "SELECT * FROM ProcessCheck WHERE RequestID = '$reqID'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $id = $row['ID'];
  $requestID = $row['RequestID'];
  $status = $row['Status'];
  $worki = $row['WorkINo'];
  $elementno = $row['ElementNo'];
  $elementname = $row['ElementName'];
  $cycletime = $row['CycleTime'];
  $efteam = $row['EFTeam'];
  $type = $row['RequestType'];
  $staff = $row['Staff'];
  $SPV = $row['SPV'];
  $MNG = $row['MNG'];
  $requestor = $row['Requestor'];
  $requestDate = $row['DateRequested'];
  /*$requestDate = date('M d, Y', strtotime($requestDate));*/
}

                //Attachment
$sql2 = "SELECT * FROM ProcessAttachment WHERE RequestID = '".$reqID."'";
$stmt2 = sqlsrv_query($conn2,$sql2);
while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
  $attachment = $row2['WindowAttach'];
  $details = $row2['Details'];
  $efficiency = $row2['EFTeam'];
  $efficiencyDate = $row2['EFDate'];
  $Staff = $row2['Staff'];
  $StaffDate = $row2['StaffDate'];
  $SPV = $row2['SPV'];
  $SPVDate = $row2['SPVDate'];
  $MNG = $row2['MNG'];
  $MNGDate = $row2['MNGDate'];

  $attachment = str_replace("\\", "/", $attachment);
  /*$attachment = substr($attachment, 35);*/
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
    <h1>Process Checking: [<?php echo $reqID;?>]</h1>

  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body" style="min-height:400px;">
            <br>
            
            <a href="ProcessChecking.php" class="btn btn-primary" style="float: right;" title="Return to Main Page"><b>Back</b></a>
            <fieldset>
            <a href="#" onclick="
                      setTimeout(function() {
                       swal({
                        title: 'Process Checking Approval',
                        text: 'Are you sure you want to approve request <?php echo $reqID;?> ?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        confirmButtonText: 'Yes, approve it!',
                        cancelButtonColor: '#',
                        cancelButtonText: 'Cancel',
                        closeOnConfirm: false,
                        closeOnCancel: true
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location = '../process/mainProcess.php?function=processApprove&id=<?php echo $reqID;?>&user=<?php echo $accounttype;?>';
                        } else {

                        }
                      });
                    }, 100);"
                    class="btn btn-success" title="Click to approve request"><strong>Approve</strong></a>

          <a href="#" class="btn btn-danger openModal" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#declineRequest" title="Click to decline request"><strong>Decline</strong></a>

           <a href="<?php echo $attachment;?>" class="btn btn-warning" target="_blank"><i class="bi bi-file-earmark-pdf" title="Click to View Request Attachment"></i> <b>Attachment</b></a>

            <a href="#" class="btn btn-info openModal" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#modalHistory" style="color: white;" title="Click to View Transaction History"><i class="bi bi-clock-history"></i> <b>History</b></a>

          </fieldset>
            <br><br>
            <table class="table table-bordered" style="font-size:15px;">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Requestor</th>
                  <th scope="col">WorkI</th>
                  <th scope="col">Element</th>
                  <th scope="col">No.</th>
                  <th scope="col">CycleTime</th>
                  <th scope="col">Type</th>
                </tr>
              </thead>
              <tbody>
                <?php
                
                echo '
                <td>'.$requestDate.'</td>
                <td>'.$requestID.'</td>
                <td>'.$worki.'</td>
                <td>'.$elementname.'</td>
                <td>'.$elementno.'</td>
                <td>'.$cycletime.'</td>
                <td>'.$type.'</td>
                ';
                ?>
              </tr>
            </tbody>
          </table>

<div class="col-lg-12">
    <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <!-- Vertical Form -->
              <form class="row g-3">
                <div class="col-3">
                  <label for="inputNanme4" class="form-label"><b>Efficiency PIC:</b></label>
                  <input type="text" class="form-control" id="efPic" readonly value="<?php echo $efficiency;?>">
                </div>
                <div class="col-3">
                  <label for="inputEmail4" class="form-label"><b>Date Approved:</b></label>
                  <input type="text" class="form-control" id="efdate" readonly value="<?php echo $efficiencyDate;?>">
                </div>
                <div class="col-3">
                  <label for="inputPassword4" class="form-label"><b>Staff PIC:</b></label>
                  <input type="text" class="form-control" id="staff" readonly value="<?php echo $Staff;?>">
                </div>
                <div class="col-3">
                  <label for="inputAddress" class="form-label"><b>Date Approved:</b></label>
                  <input type="text" class="form-control" id="staffDate" readonly value="<?php echo $StaffDate;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label"><b>Supervisor:</b></label>
                  <input type="text" class="form-control" id="spv" readonly value="<?php echo $SPV;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label"><b>Date Approved:</b></label>
                  <input type="text" class="form-control" id="spvDate" readonly value="<?php echo $SPVDate;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label"><b>Manager:</b></label>
                  <input type="text" class="form-control" id="mng" readonly value="<?php echo $MNG;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label"><b>Date Approved:</b></label>
                  <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $MNGDate;?>">
                </div>
                 <div class="col-12">
                  <label for="inputAddress" class="form-label"><b>Details:</b></label>
                  <textarea class="form-control" id="details" readonly><?php echo $details;?></textarea>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
        </div>
  </div>
</div>

</div>
</div>
</section>

<section>
  <div class="modal fade" id="modalHistory" tabindex="-1">
    <div class="modal-dialog modal-lg scrollable">
      <div class="modal-content">
       <div class="viewHistory"></div>

     </div>
   </div>
 </div>
</section>

<section>
  <div class="modal fade" id="declineRequest" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="declineRequest1"></div>

     </div>
   </div>
 </div>
</section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include '../global/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include '../global/scripts.php'; ?>

<script>
  $('.openModal').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/ProcessDecline.php?id="+id,cache:false,success:function(result){
      $(".declineRequest1").html(result);
    }});
  });
</script>

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/historyModal.php?id="+id,cache:false,success:function(result){
          $(".viewHistory").html(result);
      }});
  });
</script>
</body>

</html>