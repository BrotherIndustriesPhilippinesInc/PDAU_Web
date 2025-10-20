<?php
include '../global/conn.php';

$spv = $_POST['spv'];
$section = $_POST['section'];


$query3 = "SELECT COUNT(ID) as CheckSPV FROM Accounts WHERE FullName = '$spv' AND Section='$section' AND SystemNo=2 AND AccountType='SUPERVISOR' OR FullName in (select FullName from AdditionalSection WHERE FullName='$spv' AND Section = '$section' AND AccountType = 'SUPERVISOR')";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckSPV = $row3['CheckSPV'];

}
if ($CheckSPV == 0) {

 $data["count"] = 0;
 
}
else{
   $data["count"] = $CheckSPV;

}

echo json_encode($data);
?>

