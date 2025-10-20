<?php
session_start();
include '../global/conn.php';
include '../global/userInfo.php';
$id = $_GET['id'];

?>
<div class="modal-header">
   <h5 class="modal-title">Decline Request</h5>
</div>

<div class="modal-body">
   <form method="POST" action="process/mainProcess.php?id=<?php echo $id;?>&function=processDecline&user=<?php echo $accounttype;?>" enctype="multipart/form-data">
<div class="row mb-12">
   <label for="inputEmail3" class="col-sm-3 col-form-label">Reason:</label>
   <div class="col-sm-9">
    <textarea name="reqReason" class="form-control" id="reqReason" required autofocus></textarea>
</div>
</div>
<br>
<div class="row mb-12">
   <label for="inputEmail3" class="col-sm-3 col-form-label">Attachment:</label>
   <div class="col-sm-9">
    <input type="file" name="attachment" class="form-control" id="attachment"required>
</div>
</div>
<br>
<div class="text-center">
   <button type="button" name="btnCancel" id="btnCancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-danger">Decline</button>
</div>
</form>
</div>






