<?php 
include '../global/conn.php';

session_start();

include '../global/userInfo.php';

$id = $_GET['id'];

$sql = "SELECT * FROM SCI_Request WHERE ID = '$id'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

 $RequestDate = $row['RequestDate'];
 $RequestID = $row['RequestID'];
 $Requestor = $row['Requestor'];
 $RequestStatus = $row['Status'];
 $SCIPDF = $row['SCIPDF'];
 $RequestSection = $row['RequestSection'];
 $RequestType = $row['RequestType'];
 

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
  }

}

?>

     <div class="modal-header" >

        <h5 class="modal-title">REQUEST NUMBER: <?php echo $RequestID; ?>

      </h5>
      <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_func" name="cancel_func" style="float:right; width:55px;"><strong>X</strong></button>
      </div>
      <div class="modal-body">


         <div class="col-12">
             <table id="example1" class="table table-bordered table-hover" style="font-size: 14px;">
                    <th colspan="2" style="font-size: 20px;">Supervisor</th>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Name:</th>
                      <td><?php echo $SPV; ?></td>
                    </tr>
                      <tr>
                      <th style="width: 50%; font-weight: normal;">Judgement:</th>
                      <td><?php echo $spvStatus; ?></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Date:</th>
                      <td><?php echo $spvDate; ?></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Remarks</th>
                      <td><?php echo $spvRemarks; ?></td>
                    </tr>
                  </table>
                   
            </div>


            <div class="col-12">
             <table id="example1" class="table table-bordered table-hover" style="font-size: 14px;">
              <th colspan="2" style="font-size: 20px;">Manager</th>
              <tr>
                <th style="width: 50%; font-weight: normal;">Name:</th>
                <td><?php echo $MGR; ?></td>
              </tr>
              <tr>
                <th style="width: 50%; font-weight: normal;">Judgement:</th>
                <td><?php echo $mgrStatus; ?></td>
              </tr>
              <tr>
                <th style="width: 50%; font-weight: normal;">Date:</th>
                <td><?php echo $mgrDate; ?></td>
              </tr>
              <tr>
                <th style="width: 50%; font-weight: normal;">Remarks</th>
                <td><?php echo $mgrRemarks; ?></td>
              </tr>
            </table>
          </div>


            <div class="col-12">
              <?php if ($RequestType == 'ABOLITION') {
                ?>
                <h5 class="text-center" style="font-style: italic; font-weight: 700;color:red">No attachment available</h5>
                <?php
              } 
              else{
                ?>
                <iframe width="100%" height="300px" src="<?php echo "../SCI/$RequestSection/Request/$RequestID/$SCIPDF"; ?>"></iframe>
                <?php
              }
              ?>
          </div>


             <div class="col-12" id="divCancelOngoing" style="display: none;">
                  <h5 for="cancelReason">Input your reason for cancellation: </h5>
                <form id="cancelFormOngoing" method="POST" action="../process/mainProcess.php?function=cancelRequest&requestID=<?php echo $RequestID;?>">
                  <textarea name="cancelReason" id="cancelReason" class="form-control"></textarea>
                  <button type="submit" id="btnCancelOngoing" hidden>Save</button>
                  </form>
                   <br>
                   <br>
            </div>

             <?php

            if ($Requestor == $fullname) {
              ?>
              <div class="col-12" style="margin:auto; width:20%;">

                <?php if ($RequestStatus!='APPROVED'): ?>
                  <button onclick="showCancelOngoing();" id="btnCancelRequestOngoing" class="btn btn-danger btn-md">Cancel Request</button>
                <?php endif ?>
              </div>
                <div class="col-12" style="margin:auto; width:40%;">

                <button style="display:none" onclick="hideCancelOngoing();" id="btnDiscardOngoing" class="btn btn-secondary btn-md">Discard Cancel</button>

                <button style="display:none" onclick="submitCancelOngoing();" id="btnSubmitCancelOngoing" class="btn btn-danger btn-md">Cancel Request</button>
           
             </div>


             <?php
           }
           ?>


        </div>

          <script>
          function showCancelOngoing(){
            document.getElementById('divCancelOngoing').style.display = 'inline';
            document.getElementById('cancelReason').focus();
            document.getElementById('btnCancelRequestOngoing').style.display = 'none';

            document.getElementById('btnDiscardOngoing').style.display = 'inline';
            document.getElementById('btnSubmitCancelOngoing').style.display = 'inline';
          }

          function hideCancelOngoing(){
            document.getElementById('divCancelOngoing').style.display = 'none';
            document.getElementById('btnCancelRequestOngoing').style.display = 'inline';

            document.getElementById('btnDiscardOngoing').style.display = 'none';
            document.getElementById('btnSubmitCancelOngoing').style.display = 'none';
          }

          function submitCancelOngoing(){
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
                    document.getElementById('cancelFormOngoing').submit();
                  } else {

                  }
                });
              }, 100);
            }
          }
        </script>