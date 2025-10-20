<?php
include 'global/conn.php';
include 'global/userInfo.php';
date_default_timezone_set('Asia/Singapore');
$today = date("Y-m-d");


/*ONGOING*/
if ($section=='Common') {
 $sql = "SELECT COUNT(ID) as totalOngoing FROM SCI_Request WHERE Status NOT IN ('APPROVED', 'CANCELLED')";
}
else{
  $sql = "SELECT COUNT(ID) as totalOngoing FROM SCI_Request WHERE RequestSection = '$section' AND Status NOT IN ('APPROVED', 'CANCELLED')";
}
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $totalOngoing = $row['totalOngoing'];
}

/*SPV APPROVAL*/
if ($section=='Common') {
 $sql2 = "SELECT COUNT(ID) as totalSpvApproval FROM SCI_Request WHERE Status = 'SPV APPROVAL'";
}
else{
  $sql2 = "SELECT COUNT(ID) as totalSpvApproval FROM SCI_Request WHERE RequestSection = '$section' AND Status = 'SPV APPROVAL'";
}
$stmt2 = sqlsrv_query($conn2,$sql2);
while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
  $totalSpvApproval = $row2['totalSpvApproval'];
}

/*MGR APPROVAL*/
if ($section=='Common') {
 $sql3 = "SELECT COUNT(ID) as totalMgrApproval FROM SCI_Request WHERE Status = 'MGR APPROVAL'";
}
else{
  $sql3 = "SELECT COUNT(ID) as totalMgrApproval FROM SCI_Request WHERE RequestSection = '$section' AND Status = 'MGR APPROVAL'";
}
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $totalMgrApproval = $row3['totalMgrApproval'];
}

/*APPROVED*/
if ($section=='Common') {
 $sql4 = "SELECT COUNT(ID) as totalApproved FROM SCI_Request WHERE Status = 'APPROVED'";
}
else{
  $sql4 = "SELECT COUNT(ID) as totalApproved FROM SCI_Request WHERE RequestSection = '$section' AND Status = 'APPROVED'";
}
$stmt4 = sqlsrv_query($conn2,$sql4);
while($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
  $totalApproved = $row4['totalApproved'];
}

/*CANCELLED*/
if ($section=='Common') {
 $sql5 = "SELECT COUNT(ID) as totalCancelled FROM SCI_Request WHERE Status = 'CANCELLED'";
}
else{
  $sql5 = "SELECT COUNT(ID) as totalCancelled FROM SCI_Request WHERE RequestSection = '$section' AND Status = 'CANCELLED'";
}
$stmt5 = sqlsrv_query($conn2,$sql5);
while($row5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
  $totalCancelled = $row5['totalCancelled'];
}

/*abolished*/
if ($section=='Common') {
 $sql5 = "SELECT COUNT(ID) as totalAboished FROM SCI_MainData WHERE Status = 'Inactive'";
}
else{
  $sql5 = "SELECT COUNT(ID) as totalAboished FROM SCI_MainData WHERE Section = '$section' AND Status = 'Inactive'";
}
$stmt5 = sqlsrv_query($conn2,$sql5);
while($row5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
  $totalAboished = $row5['totalAboished'];
}


?>