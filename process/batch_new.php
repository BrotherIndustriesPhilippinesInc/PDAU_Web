<?php
$sqlsci = "SELECT COUNT(ID) as totalSCICount FROM SCI_MainData WHERE Section = '$RequestSection' ";
        $stmtsci = sqlsrv_query($conn2,$sqlsci);
        while($rowsci = sqlsrv_fetch_array($stmtsci, SQLSRV_FETCH_ASSOC)) {
          $totalSCICount = $rowsci['totalSCICount'];
        }
        if ($totalSCICount > 0) {
          $sql3 = "SELECT MAX(SCINo) as lastSCI FROM SCI_MainData WHERE Section = '$RequestSection' ";
          $stmt3 = sqlsrv_query($conn2,$sql3);
          while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
            $lastSCI = $row3['lastSCI'];
          }
          $nextSCI = substr($lastSCI, -4);
          $nextSCI = ltrim($nextSCI, "0");
          $nextSCI = $nextSCI + 1;

          $lenght = strlen($nextSCI);
          if ($lenght == 1) {
            $finalSCI = "000".$nextSCI;
          }
          elseif ($lenght == 2) {
            $finalSCI = "00".$nextSCI;
          }
          elseif  ($lenght == 3) {
            $finalSCI = "0".$nextSCI;
          }
          else{
            $finalSCI = $nextSCI;
          }
          $finalSCI = "SCI".'-'.$RequestSection.'-'.$finalSCI;
        }
        else{
          $finalSCI = "SCI".'-'.$RequestSection.'-0001';
        }

        if (!is_dir("../SCI/".$RequestSection."/MainData/".$finalSCI."/")) {
          mkdir('../SCI/'.$RequestSection.'/MainData/'.$finalSCI.'/', 0777, true);
        }

        $queryInsert = "INSERT INTO SCI_MainData(DateModified,Section,SCINo,RevNo,Title,Model,Validity,ValidityDate,IssuanceDate,Status) VALUES ('$today','$RequestSection','$finalSCI','$RevNo','$Title','$Model','$Validity','$ValidityDate','$today_noTime','Active')";
        $resultsSCI = sqlsrv_query($conn2,$queryInsert);

        $query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
        $results = sqlsrv_query($conn2,$query);

        $query2 = "UPDATE SCI_Request SET Status = 'APPROVED',Location='-',SCINo = '$finalSCI',ForFinalSCI = 1,Implement = 1 WHERE RequestID = '$requestID'";
        $results2 = sqlsrv_query($conn2,$query2);

        /*INSERT TO SCI LOGS*/
        $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved [ ".$finalSCI." ]','$fullname')";
        $resultsSCI = sqlsrv_query($conn2,$querySCI);

        /*INSERT TO DOCUMENT LOGS*/
        $queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$finalSCI','00','NEW','$RequestDetails','$Requestor','$requestID','$SPV','$MGR','$Requestor')";
        $resultsDocs = sqlsrv_query($conn2,$queryDocs);

?>