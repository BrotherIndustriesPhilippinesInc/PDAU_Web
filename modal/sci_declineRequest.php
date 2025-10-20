<?php
include '../global/conn.php';
$id = $_GET['id'];

$sql = "SELECT * FROM SCI_Request WHERE RequestID = '$id'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $id_request = $row['ID'];
  $RequestDate = $row['RequestDate'];
  $RequestID = $row['RequestID'];

}

?>
<div class="modal-header">
   <h5 class="modal-title">Decline Request</h5>
</div>
<div class="modal-body">
   <form method="POST" action="../process/mainProcess.php?requestID=<?php echo $id;?>&function=sciDecline" id="submit_decline" name="submit_decline">
      <div class="row mb-12">
       <label for="inputEmail3" class="col-sm-3 col-form-label"><b>RequestDate:</b></label>
       <div class="col-sm-9">
    <input type="text" class="form-control" id="reqDate" name="reqDate" readonly value="<?php echo $RequestDate;?>" style="background-color: transparent;">
    </div>
</div>
<br>
<div class="row mb-12">
    <label for="inputEmail3" class="col-sm-3 col-form-label"><b>RequestID:</b></label>
    <div class="col-sm-9">
     <input type="text" name="reqID" class="form-control" id="reqID" value="<?php echo $RequestID;?>" readonly style="background-color: transparent;">
 </div>
</div>
<input type="text" name="attachID" class="form-control" id="attachID" value="<?php echo $attachID;?>" hidden >
<br>
<div class="row mb-12">
   <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Reason:</b></label>
   <div class="col-sm-9">
    <textarea name="reqReason" class="form-control" id="reqReason" required autofocus style="height: 150px;"></textarea>
</div>
</div>
<input type="text" name="requestor" class="form-control" id="requestor" value="<?php echo $requestor;?>" hidden>
<br>
<div class="text-center">
   
   <button type="button" name="btnCancel" id="btnCancel" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
   <button type="button" onclick="verify_decline();" class="btn btn-danger">Decline</button>
  
  
</div>
</form>
</div>






