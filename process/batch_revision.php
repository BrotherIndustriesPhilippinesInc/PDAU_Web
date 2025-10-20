<?php

$dirPath = "../forms/";
$files = glob($dirPath . "/*");

/*CREATE REVISION NUMBER*/
$newRev = $RevNo + 1;
$lenght = strlen($newRev);

if ($lenght == 1) {
    $newRev = "0".$newRev;
}

$query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
$results = sqlsrv_query($conn2,$query);

$query2 = "UPDATE SCI_Request SET SCINo='$SCINo',RevNo='$newRev',Status = 'APPROVED',Location='-' WHERE RequestID = '$requestID'";
$results2 = sqlsrv_query($conn2,$query2);

/*INSERT TO SCI LOGS*/
$querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved [ ".$SCINo." ]','$fullname')";
$resultsSCI = sqlsrv_query($conn2,$querySCI);
$finalSCI = $SCINo.'-'.$newRev;


?>