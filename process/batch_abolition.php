<?php

$queryInsert = "UPDATE SCI_MainData SET DateModified = '$today', Status='Inactive' WHERE SCINo='$SCINo'";
$resultsSCI = sqlsrv_query($conn2,$queryInsert);

$query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
$results = sqlsrv_query($conn2,$query);

$query2 = "UPDATE SCI_Request SET Status = 'APPROVED',Location='-',Implement = 1 WHERE RequestID = '$requestID'";
$results2 = sqlsrv_query($conn2,$query2);

/*INSERT TO SCI LOGS*/
$querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved Abolition [ ".$SCINo." ]','$fullname')";
$results3 = sqlsrv_query($conn2,$querySCI);

$finalSCI = $SCINo.'-'.$RevNo;

/*INSERT TO DOCUMENT LOGS*/
$queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$SCINo','$RevNo','ABOLITION','$RequestDetails','$Requestor','$requestID','$SPV','$MGR','$Requestor')";
$resultsDocs = sqlsrv_query($conn2,$queryDocs);

$fileLocation = "../SCI/".$RequestSection."/MainData/".$SCINo."/";

/*INSERT WATERMARK*/
include 'watermark.php';

/*MOVE TO ABOLISH FOLDER*/
$currentFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/";
$newFolder = "../SCI/".$RequestSection."/Abolished/".$SCINo."/";
$files = scandir($fileLocation);

if (!is_dir($newFolder)) {
    mkdir($newFolder, 0777, true);
}

foreach($files as $fname) {
    if($fname != '.' && $fname != '..') {
        rename($fileLocation.$fname, $newFolder.$fname);
    }
}
rmdir($fileLocation); 

?>