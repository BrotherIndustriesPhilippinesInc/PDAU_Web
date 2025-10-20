<?php 
session_start();
include '../global/conn.php';
include '../global/userInfo.php';

$id = $_GET['id'];

$sql = "SELECT * FROM SCI_Request WHERE ID = '$id'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

 $RequestDate = $row['RequestDate'];
 $RequestID = $row['RequestID'];
 $Requestor = $row['Requestor'];
 

  $sql2 = "SELECT * FROM SCI_Approval WHERE RequestID = '$RequestID'";
  $stmt2 = sqlsrv_query($conn2,$sql2);
  while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
    $SPV = $row2['SPV'];
    $spvStatus = $row2['SPV_status'];
    $spvDate = $row2['SPV_date'];
    $spvRemarks = $row2['SPV_remarks'];

    $MGR = $row2['MGR'];
    $mgrStatus = $row2['MGR_status'];
    $mgrDate = $row2['MGR_date'];
    $mgrRemarks = $row2['MGR_remarks'];
    $RejectedAt = $row2['RejectedAt'];
    $AdminReject = $row2['AdminReject'];
    $AdminRejectDate = $row2['AdminRejectDate'];
  }

  if ($RejectedAt == 'SUPERVISOR') {
   $final_name = $SPV;
   $final_status = $spvStatus;
   $final_date = $spvDate;
   $final_remarks = $spvRemarks;
  }
  else if ($RejectedAt == 'MANAGER') {
   $final_name = $MGR;
   $final_status = $mgrStatus;
   $final_date = $mgrDate;
   $final_remarks = $mgrRemarks;
  }
  else{
   $final_name = $AdminReject;
   $final_status = "System Declined";
   $final_date = $AdminRejectDate;
   $final_remarks = "System Declined due to wrong template. Please use the system template.";
  }

}

?>

     <div class="modal-header" >

        <h5 class="modal-title"><span style="color:red">DECLINED REQUEST:</span> [ <?php echo $RequestID; ?> ]

      </h5>
      <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_func" name="cancel_func" style="float:right; width:55px;"><strong>X</strong></button>
      </div>
      <div class="modal-body">


         <div class="col-12">
             <table id="example1" class="table table-bordered table-hover" style="font-size: 14px;">
                    <th colspan="2" style="font-size: 20px;">Declined by :  <?php echo $RejectedAt; ?></th>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Name:</th>
                      <td><?php echo $final_name; ?></td>
                    </tr>
                      <tr>
                      <th style="width: 50%; font-weight: normal;">Judgement:</th>
                      <td style="color:red"><b><?php echo $final_status; ?></b></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Date:</th>
                      <td><?php echo $final_date; ?></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Reason for Decline:</th>
                      <td><?php echo $final_remarks?></td>
                    </tr>
                  </table>
                   
            </div>

                 <div class="col-12" id="divTable" style="display: none;">
                  <h5 for="cancelReason">Input your reason for cancellation: </h5>
                  <form id="cancelForm" method="POST" action="../process/mainProcess.php?function=cancelRequest&requestID=<?php echo $RequestID;?>">
                  <textarea name="cancelReason" id="cancelReason" class="form-control"></textarea>
                  <button type="submit" id="btnCancelProceed" hidden>Save</button>
                  </form>
                   <br>
                   <br>
            </div>

        
            <?php

            if ($Requestor == $fullname) {
              ?>
              <div class="col-12" style="margin:auto; width:40%;">

                <button onclick="showCancel();" id="btnCancelRequest" class="btn btn-danger btn-md">Cancel Request</button>

                <button style="display:none" onclick="hideCancel();" id="btnDiscard" class="btn btn-secondary btn-md">Discard Cancel</button>

                <button style="display:none" onclick="submitCancel();" id="btnSubmitCancel" class="btn btn-danger btn-md">Cancel Request</button>

               <a id="btnReapply" href="../forms/reApply.php?requestID=<?php echo $RequestID ?>&dataID=<?php echo $id; ?>" class="btn btn-success btn-md">Re-apply Request</a>
             </div>
             <?php
           }
           ?>
<!-- 
           <button onclick="myFunction1();">Try</button>
                  <input type="text" id="prompt-data"> -->

        </div>

        <script>
         /* function myFunction1() {
            var response  = document.getElementById('prompt-data').value = prompt('Please type new member name:', );
            if (response == null || response == ""){
              alert("submit");
            } else {
              alert("ng!");
            }

          }*/
          function showCancel(){
            document.getElementById('divTable').style.display = 'inline';
            document.getElementById('cancelReason').focus();
            document.getElementById('btnCancelRequest').style.display = 'none';
            document.getElementById('btnReapply').style.display = 'none';

            document.getElementById('btnDiscard').style.display = 'inline';
            document.getElementById('btnSubmitCancel').style.display = 'inline';
          }

          function hideCancel(){
            document.getElementById('divTable').style.display = 'none';
            document.getElementById('btnCancelRequest').style.display = 'inline';
            document.getElementById('btnReapply').style.display = 'inline';

            document.getElementById('btnDiscard').style.display = 'none';
            document.getElementById('btnSubmitCancel').style.display = 'none';
          }

          function submitCancel(){
            var cancelReason = document.getElementById('cancelReason').value;

            if (cancelReason == null || cancelReason == '') {
              setTimeout(function() {
                swal({
                  text: 'Input required!',
                  title: "Reason for Cancellation", 
                  type: "warning",
                  showConfirmButton: true,
                  confirmButtonText: "OK",   
                  closeOnConfirm: true 
                }, function(){
                });
              }, 100);
              $('#cancelReason').focus();
            }
            else{
              setTimeout(function() {
                swal({
                  title: 'Cancel Request',
                  text: 'Are you sure you want to Cancel request <?php echo $RequestID;?> ?',
                  /*type: 'info',*/
                  imageUrl:'../assets/img/question-red.png',
                  showCancelButton: true,
                  confirmButtonColor: 'red',
                  confirmButtonText: 'Yes, cancel it!',
                  cancelButtonColor: '#',
                  cancelButtonText: 'Cancel',
                  closeOnConfirm: false,
                  closeOnCancel: true
                },
                function(isConfirm){
                  if (isConfirm) {
                    document.getElementById('btnLoading').click();
                    document.getElementById('cancelForm').submit();
                  } else {

                  }
                });
              }, 100);
            }
          }
        </script>