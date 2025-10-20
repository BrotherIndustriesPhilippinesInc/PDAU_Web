<?php
include 'global/conn.php';
include 'global/userInfo.php';
date_default_timezone_set('Asia/Singapore');
$today = date("Y-m-d");


$sql = "SELECT COUNT(ID) as request_pending FROM RequestUpdate WHERE Location = 'SPV' AND Status = 'OPEN'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $request_pending = $row['request_pending'];
  }

  $sql2 = "SELECT COUNT(ID) as process_pending FROM ProcessCheck WHERE Location = 'SPV'";
  $stmt2 = sqlsrv_query($conn2,$sql2);
  while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
    $process_pending = $row2['process_pending'];
  }

   $sql3 = "SELECT * FROM Activity_Results WHERE ActivityDate = '$date_filter'";
  $stmt3 = sqlsrv_query($conn2,$sql3);
  while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
    $Target = $row3['Target'];
    $Actual = $row3['Actual'];

    $percentage = $Actual / $Target * 100;
    $percentage = round($percentage, 1);
  }

$sql4 = "SELECT COUNT(ID) AS jig_audit FROM JigAudit_Main WHERE DateAudit = '$date_filter'";
  $stmt4 = sqlsrv_query($conn2,$sql4);
  while($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
    $jig_audit = $row4['jig_audit'];
  }

  $sql5 = "SELECT COUNT(ID) AS grease_audit FROM GreaseAudit_Main WHERE DateAudit = '$date_filter'";
  $stmt5 = sqlsrv_query($conn2,$sql5);
  while($row5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
    $grease_audit = $row5['grease_audit'];
  }

  $sql6 = "SELECT COUNT(ID) AS torque_audit FROM TorqueAudit_Main WHERE DateAudit = '$date_filter'";
  $stmt6 = sqlsrv_query($conn2,$sql6);
  while($row6 = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {
    $torque_audit = $row6['torque_audit'];
  }

?>