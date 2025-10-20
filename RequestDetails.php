<?php
session_start();
$title = 'processDetails';
$reqID = $_GET['reqID'];
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
<?php include 'global/head.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<body>

 <?php include 'global/header.php'; ?>

 <?php include 'global/sidebar.php'; ?>

 <main id="main" class="main">

  <div class="pagetitle">
    <h1>Request For Approval: [<?php echo $reqID;?>]</h1>

  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body" style="min-height:400px;">
            <br>
            <a href="RequestForApproval.php" class="btn btn-primary" style="float: right;" title="Return to Main Page"><strong>Back</strong></a>
            <a href="#" onclick="
                      setTimeout(function() {
                       swal({
                        title: 'Request Approval',
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
                          window.location = 'process/mainProcess.php?function=requestApprove&reqID=<?php echo $reqID;?>';
                        } else {

                        }
                      });
                    }, 100);"
                    class="btn btn-success" title="Click to approve request"><strong>Approved</strong></a>



          <a href="#" class="btn btn-danger openModal" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#declineRequest" title="Click to decline request"><strong>Decline</strong></a>
          <br><br>
                <?php
                include 'global/conn.php';
                $sql = "SELECT * FROM RequestUpdate WHERE RequestID = '$reqID'";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $requestID = $row['RequestID'];
                  $status = $row['Status'];
                  $Model = $row['Model'];
                  $Process = $row['Process'];
                  $ProcessNo = $row['ProcessNo'];
                  $SeriesNo = $row['SeriesNo'];
                  $TargetDate = $row['TargetDate'];
                  $ImpDate = $row['ImpDate'];
                  $TypeTransfer = $row['TypeTransfer'];
                  $ProductSafety = $row['ProductSafety'];
                  $Categories = $row['Categories'];
                  $Requestor = $row['Requestor'];
                  $RequestDate = $row['RequestDate'];
                  $AffectedWorkI = $row['AffectedWorkI'];
                  $Urgent = $row['Urgent'];
                  $UrgentReason = $row['UrgentReason'];
                 /* $RequestDate = date('M d, Y', strtotime($RequestDate));*/
                  $TargetDate = date('F d, Y', strtotime($TargetDate));
                  $ImpDate = date('F d, Y', strtotime($ImpDate));
                

                //Attachment
                $sql2 = "SELECT * FROM RequestAttachment WHERE RequestID = '".$reqID."'";
                $stmt2 = sqlsrv_query($conn2,$sql2);
                while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                  $WindowAttach = $row2['WindowAttach'];
                  $Details = $row2['Details'];

                  $attachment = str_replace("\\", "/", $WindowAttach);
                 /* $attachment = substr($attachment, 35);*/
                }
              }
                ?>

                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"></h5>
                      <!-- Vertical Form -->
                      <form class="row g-3">
                        <div class="col-3">
                          <label for="inputNanme4" class="form-label"><b>Date Requested:</b></label>
                          <input type="text" class="form-control" id="efPic" readonly value="<?php echo $RequestDate;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputEmail4" class="form-label"><b>Requestor:</b></label>
                          <input type="text" class="form-control" id="efdate" readonly value="<?php echo $Requestor;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputPassword4" class="form-label"><b>Type of Request:</b></label>
                          <input type="text" class="form-control" id="staff" readonly value="<?php echo $TypeTransfer;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Category:</b></label>
                          <input type="text" class="form-control" id="spv" readonly value="<?php echo $Categories;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Model</b></label>
                          <input type="text" class="form-control" id="spv" readonly value="<?php echo $Model;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Process:</b></label>
                          <input type="text" class="form-control" id="spvDate" readonly value="<?php echo $Process;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Process No:</b></label>
                          <input type="text" class="form-control" id="mng" readonly value="<?php echo $ProcessNo;?>">
                        </div>

                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Series No:</b></label>
                          <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $SeriesNo;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Work Instruction:</b></label>
                          <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $AffectedWorkI;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Target Date:</b></label>
                          <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $TargetDate;?>">
                        </div>
                        <div class="col-3">
                          <label for="inputAddress" class="form-label"><b>Implement Date:</b></label>
                          <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $ImpDate;?>">
                        </div>
                            <div class="col-1">
                          <label for="inputAddress" class="form-label"><b>P.S</b></label>
                          <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $ProductSafety;?>">
                        </div>
                        <div class="col-1">
                          <label for="inputAddress" class="form-label"><b>Urgent:</b></label>
                          <input type="text" class="form-control" id="staffDate" readonly value="<?php echo $Urgent;?>">
                        </div>
                       <div class="col-4">
                          <label for="inputAddress" class="form-label"><b>Reason:</b></label>
                          <textarea class="form-control" id="staffDate" readonly ><?php echo $UrgentReason;?></textarea>
                        </div>
                           <div class="col-4">
                          <label for="inputAddress" class="form-label"><b>Request Details:</b></label>
                           <textarea class="form-control" id="staffDate" readonly ><?php echo $Details;?></textarea>
                        </div>
                         
                        <div class="col-4">
                          <label for="inputAddress" class="form-label"><b>Attachment:</b></label>
                           <label for="inputAddress" class="form-label" style="float: right;"><b>History:</b></label>
                          <br>
                          <a href="<?php echo $attachment;?>" target="_blank" style="color: #F40F02; font-size: 45px;"><i class="bi bi-file-earmark-pdf" title="Click to View Request Attachment"></i></a>
                          <a href="#" class="openModal" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#modalHistory" style="color: green; font-size: 45px; float: right;" title="Click to View Transaction History"><i class="bi bi-clock-history"></i></a>
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
    <div class="modal-dialog modal-lg">
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
<?php include 'global/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include 'global/scripts.php'; ?>

<script>
  $('.openModal').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"modal/declineRequest.php?id="+id,cache:false,success:function(result){
      $(".declineRequest1").html(result);
    }});
  });
</script>

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({url:"modal/historyModal.php?id="+id,cache:false,success:function(result){
          $(".viewHistory").html(result);
      }});
  });
</script>
</body>

</html>