<?php 
include '../global/conn.php';

session_start();

$id = $_GET['id'];

$sql = "SELECT * FROM SCI_Request WHERE ID = '$id'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

 $RequestDate = $row['RequestDate'];
 $RequestID = $row['RequestID'];
 
 }



?>

     <div class="modal-header" >

        <h5 class="modal-title">REQUEST LOGS: [ <?php echo $RequestID; ?> ]

      </h5>
      <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_func" name="cancel_func" style="float:right; width:55px;"><strong>X</strong></button>
      </div>
      <div class="modal-body">



       <div class="col-12">
         <table id="example1" class="table table-bordered table-hover" style="font-size: 14px;">
          <tr>
            <th>Date of Logs</th>
            <th>Event</th>
            <th>User</th>
          </tr>
          <tbody>
            <tr>
              <?php
              $sql2 = "SELECT * FROM SCI_RequestLogs WHERE RequestID = '$RequestID' ORDER BY ID DESC";
              $stmt2 = sqlsrv_query($conn2,$sql2);
              while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                $logID = $row2['ID'];
                $TransactionDate = $row2['TransactionDate'];
                $RequestID = $row2['RequestID'];
                $Event = $row2['Event'];
                $AccountName = $row2['AccountName'];

                echo 
                '<td>'.$TransactionDate.'</td>
                <td>'.$Event.'</td>
                <td>'.$AccountName.'</td>

                ';
                ?>
                </tr>
                <?php
              }

              ?>
            
          </tbody>
        </table>
      </div>

        </div>