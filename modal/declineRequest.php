<?php
include '../global/conn.php';
$id = $_GET['id'];

$sql = "SELECT * FROM RequestUpdate WHERE RequestID = '".$id."' ORDER BY ID DESC ";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $status = $row['Status'];
    $requestID = $row['RequestID'];
    $model = $row['Model'];
    $process = $row['Process'];
    $processno = $row['ProcessNo'];
    $series = $row['SeriesNo'];
    $worki = $row['AffectedWorkI'];
    $targetdate = $row['TargetDate'];
    $impdate = $row['ImpDate'];
    $typetransfer = $row['TypeTransfer'];
    $safety = $row['ProductSafety'];
    $category = $row['Categories'];
    $requestor = $row['Requestor'];
    $requestDate = $row['RequestDate'];
    $requestDate = date('F d, Y', strtotime($requestDate));

    $sql2 = "SELECT * FROM RequestAttachment WHERE RequestID = '".$requestID."' AND Status = 'OPEN'";
    $stmt2 = sqlsrv_query($conn2,$sql2);
    while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        $attachID = $row2['ID'];
    }
}

?>
<div class="modal-header">
   <h5 class="modal-title">Decline Request</h5>
</div>
<div class="modal-body">
   <form method="POST" action="process/mainProcess.php?id=<?php echo $id;?>&function=reqDecline">
      <div class="row mb-12">
       <label for="inputEmail3" class="col-sm-3 col-form-label">RequestDate</label>
       <div class="col-sm-9">
    <input type="text" class="form-control" id="reqDate" name="reqDate" disabled value="<?php echo $requestDate;?>">
    </div>
</div>
<br>
<div class="row mb-12">
    <label for="inputEmail3" class="col-sm-3 col-form-label">RequestID</label>
    <div class="col-sm-9">
     <input type="text" name="reqID" class="form-control" id="reqID" value="<?php echo $id;?>" disabled>
 </div>
</div>
<input type="text" name="attachID" class="form-control" id="attachID" value="<?php echo $attachID;?>" hidden>
<br>
<div class="row mb-12">
   <label for="inputEmail3" class="col-sm-3 col-form-label">Reason</label>
   <div class="col-sm-9">
    <textarea name="reqReason" class="form-control" id="reqReason" required autofocus style="height: 150px;"></textarea>
</div>
</div>
<input type="text" name="requestor" class="form-control" id="requestor" value="<?php echo $requestor;?>" hidden>
<br>
<div class="text-center">
   
   <button type="button" name="btnCancel" id="btnCancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
   <button type="submit" class="btn btn-default">Decline</button>
  
  
</div>
</form>
</div>






