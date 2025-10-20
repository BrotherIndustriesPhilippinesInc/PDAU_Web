<?php
include '../global/conn.php';
$id = $_GET['id'];

$sql = "SELECT * FROM RequestAttachment WHERE RequestID = '".$id."' AND Status='OPEN' ORDER BY ID DESC ";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $attachment = $row['WindowAttach'];
    $details = $row['Details'];
    $attachment = str_replace("\\", "/", $attachment);
    $attachment = substr($attachment, 35);
}

?>
<div class="modal-header">
   <h5 class="modal-title">Details: RequestID No. <?php echo $id;?></h5>
</div>
<div class="modal-body">
      <div class="row mb-12">
       <label for="inputEmail3" class="col-sm-3 col-form-label">Details:</label>
       <div class="col-sm-9">
    <textarea type="text" class="form-control" id="reqDate" name="reqDate" readonly rows="4">
        <?php echo $details;?></textarea>
    </div>
</div>

<br>
<div class="text-center">
    <a class="btn btn-primary" target="_blank" href="<?php echo $attachment;?>">View Attachment</a>
  <button type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
</div>
</div>






