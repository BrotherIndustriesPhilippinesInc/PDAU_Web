<?php 

// CHECK IF HAVE SESSION IN PORTAL
$sql = "SELECT TOP(1) USERNAME FROM Tbl_lOGIN_Request WHERE HOSTNAME = '$ip_client' AND STATUS = 'ACTIVE' ORDER BY ID DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn_portal, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );

 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $username_login = $row['USERNAME'];
}

if ($BIPH_ID == "99") {
	// nothing happens
}
else if ($BIPH_ID != $username_login) {

	/*header("Location:../index.php");*/
	?>
	<script type="text/javascript">
		window.location.replace('../index.php');
	</script>
	<?php
}
else{
	// nothing happens
}


?>