<?php 
session_start();
$title = 'sci_maindata';
$page = 'sci_data';

$user_login = $_SESSION['pdau_id'];
 
include '../global/conn.php';
include '../global/userInfo.php';
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "Special-Check-Items-MasterList_".$section."_".date('Ymd').".xlsx"; 
 
// Define column names 
$excelData[] = array('NO','Section', 'SCI Document Number', 'Title of the Document', 'Date Prepared', 'Issued Date','Validity','Validity Date','Status',);

if ($accountCode == 3) { 
	$sql = "SELECT ROW_NUMBER() OVER(ORDER BY SCINo ASC) AS RowNo,* FROM SCI_MainData ORDER BY SCINo ASC";
}
else{
	$sql = "SELECT ROW_NUMBER() OVER(ORDER BY SCINo ASC) AS RowNo,* FROM SCI_MainData WHERE Section = '$section' ORDER BY SCINo ASC";
}
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	$lineData = array($row['RowNo'],$row['Section'], $row['SCINo'].'-'.$row['RevNo'], $row['Title'], $row['DateModified'], $row['IssuanceDate'],$row['Validity'],$row['ValidityDate'], $row['Status']);  
	$excelData[] = $lineData; 
}
 

// Export data to excel and download as xlsx file 
$xlsx = PDAU\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>