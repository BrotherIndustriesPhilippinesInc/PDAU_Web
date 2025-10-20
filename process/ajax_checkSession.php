<?php
session_start();

$dummy_session = $_POST['dummy_session'];

if (!$_SESSION['pdau_id']) {
	$data["valid"] = 0;
}
else{
	$data["valid"] = 1;
}


echo json_encode($data);
?>

