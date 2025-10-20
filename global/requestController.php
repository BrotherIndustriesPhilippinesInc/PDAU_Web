<?php
include 'conn.php';

$reqID = $_GET['reqID'];
$control = $_GET['control'];


if ($reqID == null || $reqID == "" ) {
	$reqID = "0";
}

if ($control == null || $control == "" ) {
	$control = "0";
}

// CHECK IF HAVE SESSION IN PORTAL
$sql = "SELECT TOP(1) USERNAME FROM Tbl_lOGIN_Request WHERE HOSTNAME = '$ip_client' AND STATUS = 'ACTIVE' ORDER BY ID DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn_portal, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );

 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $username = $row['USERNAME'];
}



// MAY SESSION - DISREGARD KUNG ANONG SYSTEM ANG LOGIN
if ($row_count >=1) {
	header("Location:../process/mainProcess.php?function=login&reqID=$reqID&control=$control&username=$username");
}
else{
	//pop-up yung instruction ng login
	header("Location:../process/mainProcess.php?function=errorLogin&reqID=$reqID&control=$control&username=$username");
}



require_once 'scripts.php';

?>

