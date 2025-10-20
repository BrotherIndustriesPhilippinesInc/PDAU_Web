<?php
include '../global/conn.php';

$sciNo_rev = $_POST['sciNo_rev'];
$section_rev = $_POST['section_rev'];

$query3 = "SELECT COUNT(SCINo) as CheckSCI FROM SCI_MainData WHERE SCINo = '$sciNo_rev' AND Section = '$section_rev' AND Status = 'Active'";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckSCI = $row3['CheckSCI'];

}
if ($CheckSCI == 0) {

 $data["count"] = 0;
 $data["revNo_rev"] ="";
 $data["title_rev"] = "";
 $data["model_rev"] = "";
 $data["validity_check"] = "";
}
else{

$query = "SELECT * FROM SCI_MainData WHERE SCINo = '$sciNo_rev'";
$stmt = sqlsrv_query($conn2,$query);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

  $revNo = $row['RevNo'];
  $model = $row['Model'];
  $title = $row['Title'];
  $validity = $row['Validity'];
  $validity_date = $row['ValidityDate'];

  $data["count"] = 1;
  $data["revNo_rev"] = $revNo;
  $data["model_rev"] = $model;
  $data["title_rev"] = $title;
  $data["validity_check"] = $validity;
  $data["validity_date"] = $validity_date;

}
}

echo json_encode($data);
?>

