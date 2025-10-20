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
 

  $sql2 = "SELECT * FROM SCI_Cancel WHERE RequestID = '$RequestID'";
  $stmt2 = sqlsrv_query($conn2,$sql2);
  while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
    $CancelDate = $row2['CancelDate'];
    $CancelReason = $row2['CancelReason'];
    $Requestor_cancel = $row2['Requestor'];
  }


}

?>

     <div class="modal-header" >

        <h5 class="modal-title">CANCELLED REQUEST

      </h5>
      <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_func" name="cancel_func" style="float:right; width:55px;"><strong>X</strong></button>
      </div>
      <div class="modal-body">


         <div class="col-12">
             <table id="example1" class="table table-bordered table-hover" style="font-size: 14px;">
                    <th colspan="2" style="font-size: 20px;"><?php echo $RequestID; ?></th>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Name:</th>
                      <td><?php echo $Requestor_cancel; ?></td>
                    </tr>
                      <tr>
                      <th style="width: 50%; font-weight: normal;">Status:</th>
                      <td style="color: #FFC107;"><b>CANCELLED</b></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Date:</th>
                      <td><?php echo $CancelDate; ?></td>
                    </tr>
                    <tr>
                      <th style="width: 50%; font-weight: normal;">Reason for Cancellation:</th>
                      <td><?php echo $CancelReason?></td>
                    </tr>
                  </table>
                   
            </div>

        
          