<?php
include '../global/conn.php';

$biph_id = $_POST['biph_id'];

$query3 = "SELECT COUNT(EmpNo) as CheckMain FROM EmployeeDetails WHERE EmpNo = '$biph_id'";
$stmt3 = sqlsrv_query($conn2,$query3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
$CheckMain = $row3['CheckMain'];

}
if ($CheckMain == 0) {

 $data["count"] = 0;
 $data["checkID"] = 1;
 $data["adid"] ="";
 $data["fullname"] = "";
 $data["dept"] = "";
 $data["section"] = "";
 $data["position"] = "";
 $data["emailadd"] = "";

}
else{

$query = "SELECT * FROM EmployeeDetails WHERE EmpNo = '$biph_id'";
$stmt = sqlsrv_query($conn2,$query);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

  $adid = $row['ADID'];
  $fullname = $row['Full_Name'];
  /*$fullname = utf8_encode($fullname);*/
  $dept = $row['Department'];
  $section = $row['Section'];
  $position = $row['Position'];
  $emailadd = $row['Email'];

  $staffEng = array("Junior Staff","Staff","Senior Staff","Engineer","Senior Engineer","Leader","Assistant Leader");
  $spv = array("Junior Supervisor","Supervisor","Senior Supervisor","Specialist","Junior Specialist","Senior Specialist");
  $mgr = array("Assistant Manager","Manager","Senior Manager","Deputy General Manager","General Manager","Factory Manager");

  if(in_array($position, $staffEng, true)) {
    $position_final = 'STAFF/ENGINEER';
  }
  else if(in_array($position, $spv, true)) {
   $position_final = 'SUPERVISOR';
  }
  else if(in_array($position, $mgr, true)) {
   $position_final = 'MANAGER';
  }
  else{
    $position_final = "COMMON";
  }

  if ($adid == null || $adid == "") {
   $position_final = "COMMON";
  }


$query2 = "SELECT COUNT(ID) as Exist FROM Accounts WHERE BIPH_ID = '$biph_id'";
$stmt2 = sqlsrv_query($conn2,$query2);
while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
$count = $row2['Exist'];

  $data["count"] = $count;
  $data["checkID"] = 0;
  $data["adid"] = $adid;
  $data["fullname"] = $fullname;
  $data["dept"] = $dept;
  $data["section"] = $section;
  $data["position"] = $position_final;
  $data["emailadd"] = $emailadd;

}
}
}

echo json_encode($data);
?>

