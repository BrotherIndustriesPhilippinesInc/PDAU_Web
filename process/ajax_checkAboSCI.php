<?php
include '../global/conn.php';

$sciNo_abo = $_POST['sciNo_abo'];
$section_abo = $_POST['section_abo'];

$query3 = "SELECT COUNT(SCINo) as CheckSCI FROM SCI_MainData WHERE SCINo = '$sciNo_abo' AND Section = '$section_abo' AND Status = 'Active'";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckSCI = $row3['CheckSCI'];

}
if ($CheckSCI == 0) {

 $data["count"] = 0;
 $data["revNo_abo"] ="";
 $data["title_abo"] = "";
 $data["model_abo"] = "";
 $data["validity_abo"] = "";
 $data["validity_date_abo"] = "";
}
else{

$checkQry = "SELECT COUNT(ID) as TotalActiveRequest FROM SCI_Request WHERE SCINo = '$sciNo_abo' AND Status NOT IN ('APPROVED','CANCELLED','DECLINED')";
$stmtQry = sqlsrv_query($conn2,$checkQry);
while($rowQry = sqlsrv_fetch_array($stmtQry, SQLSRV_FETCH_ASSOC)) {
  $TotalActiveRequest = $rowQry['TotalActiveRequest'];
}

if ($TotalActiveRequest > 0) {
  // HAVE ACTIVE REQUEST
  $data["count"] = 2;
  $data["revNo_abo"] ="";
  $data["title_abo"] = "";
  $data["model_abo"] = "";
  $data["validity_abo"] = "";
  $data["validity_date_abo"] = "";
}
else{

  $query = "SELECT * FROM SCI_MainData WHERE SCINo = '$sciNo_abo'";
  $stmt = sqlsrv_query($conn2,$query);

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $revNo = $row['RevNo'];
    $model = $row['Model'];
    $title = $row['Title'];
    $validity = $row['Validity'];
    $validity_date = $row['ValidityDate'];
    $sciFile = $row['SCIFile'];

    $data["count"] = 1;
    $data["revNo_abo"] =$revNo;
    $data["title_abo"] = $title;
    $data["model_abo"] = $model;
    $data["validity_abo"] = $validity;
    $data["validity_date_abo"] =$validity_date;
    $data["sciFile"] =$sciFile;

    }
  }
}

echo json_encode($data);
?>

