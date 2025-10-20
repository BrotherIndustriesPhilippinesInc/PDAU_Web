<?php
include '../global/conn.php';
session_start();
$page = "sciApproval";
$title = 'sciForApproval';
$reqID = $_GET['reqID'];

include '../global/userInfo.php';

if ($reqID == null || $reqID == "") {
  header('Location:dashboard-sci.php');
}

if ($accounttype != 'SUPERVISOR' && $accounttype != 'MANAGER') {
  ?>
  <script type="text/javascript">
    alert('Access Denied!');
    window.location.replace('dashboard-sci.php');
  </script>
  <?php
}

$sql = "SELECT * FROM SCI_Request WHERE RequestID = '$reqID' AND Status NOT IN ('DECLINED','APPROVED','CANCELLED')";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn2, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );


if ($row_count <=0) {
  ?>
  <script>
   alert("Request Number is invalid. Please check the link or ask for BPS support.");
   window.location.replace("dashboard-sci.php");
  </script>
  <?php

}
else{
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $id_request = $row['ID'];
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

  if ($RequestType !='NEW') {
    $sql_attach = "SELECT SCIFile FROM SCI_MainData WHERE SCINo = '$SCINo'";
    $stmt_attach = sqlsrv_query($conn2,$sql_attach);
    while($row_attach = sqlsrv_fetch_array($stmt_attach, SQLSRV_FETCH_ASSOC)) {
      $SCIFile = $row_attach['SCIFile'];
    }
  }


}
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

<style type="text/css">
  div.iframe-link {
    position: relative;
    float: left;
    width: 960px;
    height: 30px;
  }
  a.iframe-link {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: #ffffff;
    opacity: 0.1;
    filter:Alpha(opacity=10);
  }
</style>
<body>

 <?php include '../global/header.php'; ?>

 <?php include '../global/sidebar.php'; ?>

 <main id="main" class="main">

  <div class="pagetitle">
    <h1><?php echo $reqID;?></h1>

  </div><!-- End Page Title -->

  

  <section class="section">

   <!--  <a href="RequestForApproval.php" class="btn btn-primary" style="float: right;" title="Return to Main Page"><strong>Cancel</strong></a>
    <a class="openSCILogs" title="Request Logs" id="launchModal" href="#" data-id="<?php echo $id; ?>" data-toggle="modal" data-target="#viewSCILogs"><img src="../assets/img/log.png" width="40px;"></a>
    <br><br> -->
    <div class="row">
      <div class="col-lg-6">

        <div class="card">
          <div class="card-body" style="min-height:500px">
            <h5 class="card-title">Request Details<a class="openSCILogs" id="launchModal" href="#" data-id="<?php echo $id_request; ?>" data-toggle="modal" data-target="#viewSCILogs" data-bs-toggle="tooltip" data-bs-placement="top" title="View Request Logs" style="float: right;"><img src="../assets/img/log.png" width="40px;"></a>
               <?php
               if ($RequestType == 'REVISION') {
                echo '<a target="_blank" href="../SCI/'.$section.'/MainData/'.$SCINo.'/'.$SCIFile.'#page=1&zoom=100" data-bs-toggle="tooltip" data-bs-placement="top" title="View Current SCI Document"  style="float:right;"><img src="../assets/img/pdf.png" width="40px;"></a>
                ';
               }
               ?> 
             </h5>
            <!-- Horizontal Form -->
            <br>
            <form class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingName" placeholder="Your Name" value="<?php echo $RequestDate; ?>" style="font-size: 14px;" readonly>
                  <label for="floatingName">Requested Date</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingEmail" placeholder="Your Email" value="<?php echo $RequestType ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Request Type</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating">
                <input type="text" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo $SCINo_final ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Current Doc / SCI Number </label>
                </div>
              </div>

              
              <div class="col-md-8">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingEmail" placeholder="Your Email" value="<?php echo $Title ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Title</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                <input type="text" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo $Model ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Model</label>
                </div>
              </div>


              <div class="col-md-3">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingEmail" placeholder="Your Email" value="<?php echo $Validity ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Validity</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-floating">
                <input type="text" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo $ValidityDate ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Valid Date</label>
                </div>
              </div>

               <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 90px;font-size: 14px;" readonly><?php echo $RequestDetails; ?></textarea>
                  <label for="floatingTextarea">Request Details</label>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingEmail" placeholder="Your Email" value="<?php echo $Requestor ?>" readonly style="font-size: 14px;">
                  <label for="floatingEmail">Requestor</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingName" placeholder="Your Name" value="<?php echo $RequestSection; ?>" readonly style="font-size: 14px;">
                  <label for="floatingName">Section</label>
                </div>
              </div>
              <div class="col-12"></div>
              <div class="text-center">
                <span class="openDecline" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#sci_declineRequest">
                  <a href="#" class="btn btn-danger btn-lg " data-bs-toggle="tooltip" data-bs-placement="top" title="Click to decline request"><strong><i class="bi bi-hand-thumbs-down"></i> Decline</strong></a>
                </span>
                <a href="#" onclick="
                setTimeout(function() {
                  swal({
                    title: 'Request for Approval',
                    text: 'Are you sure you want to approve request <?php echo $reqID;?> ?',
                    /*type: 'info',*/
                    imageUrl:'../assets/img/question-red.png',
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
                      document.getElementById('btnLoading').click();
                      window.location = '../process/mainProcess.php?function=sciApproval&requestID=<?php echo $reqID;?>&requestType=<?php echo $RequestType; ?>';
                    } else {

                    }
                  });
                }, 100);"
                class="btn btn-success btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to approve request"><strong><i class="bi bi-hand-thumbs-up"></i> Approve</strong></a>

              </div>
            </form><!-- End Horizontal Form -->

          </div>
        </div>



      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body" style="height: 575px;">
            <?php
            if ($RequestType !='ABOLITION') {
              ?>
              <h5 class="card-title">Attachment
               <a target="_blank" href="../SCI/<?php echo $RequestSection; ?>/Request/<?php echo $reqID."/".$SCIPDF; ?>#page=1&zoom=100" class="btn btn-warning btn-sm" style="float:right;">Click to View Full Page</a>


               <a class="btn btn-primary btn-sm openDocsLogsDetails" id="openDetails" href="#" data-id="<?php echo $SCINo ?>" data-toggle="modal" data-target="#viewDocsLogsDetails" title="View Document Logs" style="float:right;">View SCI Document Logs</a>


               </h5>
               <br>
               <form class="row g-3">
                <iframe src="../SCI/<?php echo $RequestSection; ?>/Request/<?php echo $reqID."/".$SCIPDF; ?>#page=1&zoom=50" height="475px;" class="prevent-select"></iframe>
              <?php
            }
            else{
              ?>
              <h5 class="card-title">Current SCI Document
                <a target="_blank" href="../SCI/<?php echo $RequestSection ?>/MainData/<?php echo $SCINo.'/'.$SCIFile;?>#page=1&zoom=100" class="btn btn-warning btn-sm" style="float:right;">Click to View Full Page</a>
              </h5>
              <br>
              <form class="row g-3">
                 <iframe src="../SCI/<?php echo $RequestSection ?>/MainData/<?php echo $SCINo.'/'.$SCIFile;?>#page=1&zoom=50" height="475px;"></iframe>
              <?php
            }
            ?>
             
            </form><!-- End floating Labels Form -->

          </div>
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
  <div class="modal fade" id="sci_declineRequest" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="sci_declineRequest1"></div>

     </div>
   </div>
 </div>
</section>

<section>
      <div class="modal fade" id="viewDocsLogsDetails" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="displayDocsLogsDetails"></div>
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
  $('.openDecline').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/sci_declineRequest.php?id="+id,cache:false,success:function(result){
      $(".sci_declineRequest1").html(result);
    }});
  });

    $('.openSCILogs').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/sci_logs.php?id="+id,cache:false,success:function(result){
      $(".displaySCILogs").html(result);
    }});
  });


 
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#sci_declineRequest").on('shown.bs.modal', function(){
      /*$('#updatesupplier').trigger('focus');*/
      $('#reqReason').focus();

    });
  });
</script>

<script type="text/javascript">
  function verify_decline() {

    var reqReason = $('#reqReason').val();
    var reqID = $('#reqID').val();


    if (reqReason == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Reason for Decline", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#reqReason').focus();
    }
    else{
      setTimeout(function() {
        swal({
          title: 'Decline Request',
          text: 'Are you sure you want to decline ['+reqID+'] ?',
          imageUrl: '../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: 'red',
          confirmButtonText: 'Yes, decline it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {

            document.getElementById("btnLoading").click();
            document.getElementById("submit_decline").submit();
          } else {

          }
        });
      }, 100);

    }

  }

</script>



</body>

</html>