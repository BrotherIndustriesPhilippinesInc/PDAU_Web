<?php
error_reporting(0);
include 'conn.php';
$sql = "SELECT * FROM Accounts WHERE BIPH_ID =  '".$_SESSION['pdau_id']."' ";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $id = $row['ID'];
  $BIPH_ID = $row['BIPH_ID'];
  $useradid = $row['UserADID'];
  $fullname = $row['FullName'];
  $department = $row['Department'];
  $section = $row['Section'];
  $emailaddress = $row['EmailAddress'];
  $accounttype = $row['AccountType'];
  $accountstatus = $row['AccountStatus'];
  $registerPIC = $row['RegisterPIC'];
  $systemPass = $row['SystemPassword'];
  $registerDate = $row['RegisterDate'];
  $systemNo = $row['SystemNo'];
  $accountCode = $row['AccountCode'];
  /*$registerDate = date('F d, Y', strtotime($registerDate));*/
}
?>