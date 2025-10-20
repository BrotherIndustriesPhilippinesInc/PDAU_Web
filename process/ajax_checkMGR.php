<?php
include '../global/conn.php';

$mgr = $_POST['mgr'];
$section = $_POST['section'];


$query3 = "SELECT COUNT(ID) as CheckMGR FROM Accounts WHERE FullName = '$mgr' AND Section='$section' AND SystemNo=2 AND AccountType='MANAGER' OR FullName in (select FullName from AdditionalSection WHERE FullName='$mgr' AND Section = '$section' AND AccountType = 'MANAGER')";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckMGR = $row3['CheckMGR'];

}
if ($CheckMGR == 0) {

 $data["count"] = 0;
 
}
else{
   $data["count"] = $CheckMGR;

}

echo json_encode($data);
?>

