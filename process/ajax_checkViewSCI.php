<?php
include '../global/conn.php';

$sciNo = $_POST['sciNo'];
$sci_section = $_POST['sci_section'];
$user_section = $_POST['user_section'];

$query3 = "SELECT COUNT(SCINo) as CheckSCI FROM SCI_MainData WHERE SCINo = '$sciNo' AND Status = 'Active'";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckSCI = $row3['CheckSCI'];

}
if ($CheckSCI == 0) {

 $data["count"] = 0;
 $data["SCI"] ="";
 $data["REV"] = "";
}
else{

$query = "SELECT * FROM SCI_MainData WHERE SCINo = '$sciNo' AND Status = 'Active'";
$stmt = sqlsrv_query($conn2,$query);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

  $SCINo = $row['SCINo'];
  $RevNo = $row['RevNo'];
  $Section = $row['Section'];

  if ($user_section == 'Common') {
    $data["count"] = 1;
    $data["SCI"] =$SCINo;
    $data["REV"] = $RevNo;
  }
  else{
   if ($sci_section!=$Section) {
    $data["count"] = 99;
    $data["SCI"] ="";
    $data["REV"] = "";
    }
    else{
     $data["count"] = 1;
     $data["SCI"] =$SCINo;
     $data["REV"] = $RevNo;
    }
  }

}
}

echo json_encode($data);
?>

