<?php

include '../global/conn.php';

$section = $_GET['section'];

$sql = "SELECT * from SCI_MainData where Validity = 'Temporary' AND Section = '$section' AND Status='Active' AND (CONVERT(date,ValidityDate) <= CONVERT(date, GETDATE()))";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$results = sqlsrv_query( $conn2, $sql , $params, $options );
$count = sqlsrv_num_rows( $results );

if ($count >=1) {

  /*EMAIL*/
  include_once '../email/abolishedSCI.php';

  while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $Section = $row['Section'];
    $SCINo = $row['SCINo'];
    $RevNo = $row['RevNo'];
    $Title = $row['Title'];
    $Model = $row['Model'];
    $Validity = $row['Validity'];
    $ValidityDate = $row['ValidityDate'];
    $SciNoFinal = $SCINo.'-'.$RevNo;
    $SCIFile = $row['SCIFile'];

    $queryInsert = "UPDATE SCI_MainData SET DateModified = '$today', Status='Inactive' WHERE SCINo='$SCINo'";
    $resultsSCI = sqlsrv_query($conn2,$queryInsert);

    $finalSCI = $SCINo.'-'.$RevNo;

    $details = "Abolished by System due to the expiration of Validity Date";

    /*INSERT TO DOCUMENT LOGS*/
    $queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$SCINo','$RevNo','ABOLITION','$details','-','-','-','-','System')";
    $resultsDocs = sqlsrv_query($conn2,$queryDocs);

    $fileLocation = "../SCI/".$section."/MainData/".$SCINo."/";


    /*INSERT WATERMARK*/
    $fileExt  = (new SplFileInfo($SCIFile))->getExtension();
    if ($fileExt == 'pdf') {
    require_once 'watermark.php';
    }
   /* else{
      require_once 'watermark_img.php';
    }*/


    /*MOVE TO ABOLISH FOLDER*/

    $newFolder = "../SCI/".$section."/Abolished/".$SCINo."/";
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
  }

  ?>
  <script type="text/javascript">
    function closeForm() {
      window.close();
    }
   setInterval(closeForm, 10000); 
 </script>
  <?php

}

/*NO DATA FOR ABOLISHMENT*/
else{
  ?>
  <script type="text/javascript">
      function closeForm() {
      window.close();
    }
   setInterval(closeForm, 3000); 
  </script>
  <?php

}



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System Abolishment - Process Document Auto Updater</title>
    <link rel="icon" href="../assets/img/update.png" type="image/gif" sizes="16x16">
</head>
<body>
  <div style="display: flex;justify-content: center;align-content: center;">
   <img src="../assets/img/loading_pdau.gif" >
  </div>
  <div style="display: flex;justify-content: center;align-content: center;">
    <h2>System Abolishment working. Please do not close.</h2>
  </div>

</body>
</html>