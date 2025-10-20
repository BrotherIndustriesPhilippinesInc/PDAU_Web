<?php

include '../global/conn.php';

$sql = "SELECT * FROM SCI_Request where Status = 'DECLINED' AND DATEDIFF(DAY, CAST(RequestDate AS date), GETDATE()) > 30;";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$results = sqlsrv_query( $conn2, $sql , $params, $options );
$count = sqlsrv_num_rows( $results );

if ($count >=1) {

  while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $RequestID = $row['RequestID'];

    $queryInsert = "UPDATE SCI_Request SET Status = 'CANCELLED' WHERE RequestID = '$RequestID'";
    $resultsSCI = sqlsrv_query($conn2,$queryInsert);

    $details = "Auto Cancel by System";

    /*INSERT TO SCI CANCEL LOGS*/
    $queryCancel = "INSERT INTO SCI_Cancel(CancelDate,CancelReason,RequestID,Requestor) VALUES ('$today','$details','$RequestID','System')";
    $resultsCancel = sqlsrv_query($conn2,$queryCancel);

    /*INSERT TO DOCUMENT LOGS*/
    $queryLogs = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$RequestID','$details','System')";
    $resultLogs = sqlsrv_query($conn2,$queryLogs);

  }

  ?>
  <script type="text/javascript">
    function closeForm() {
      window.close();
    }
   setInterval(closeForm, 10000); 
 </script>
  <?php

}

/*NO DATA FOR ABOLISHMENT*/
else{
  ?>
  <script type="text/javascript">
      function closeForm() {
      window.close();
    }
   setInterval(closeForm, 3000); 
  </script>
  <?php

}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System Cancellation - Process Document Auto Updater</title>
    <link rel="icon" href="../assets/img/update.png" type="image/gif" sizes="16x16">
</head>
<body>
  <div style="display: flex;justify-content: center;align-content: center;">
   <img src="../assets/img/loading_pdau.gif" >
  </div>
  <div style="display: flex;justify-content: center;align-content: center;">
    <h2>System Abolishment working. Please do not close.</h2>
  </div>

</body>
</html>