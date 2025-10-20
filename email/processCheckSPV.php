<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

/*$reqID = 'REQ-19';*/

$sql10 = "SELECT * FROM ProcessCheck WHERE RequestID = '$id'";
$stmt10 = sqlsrv_query($conn2,$sql10);
while($row10 = sqlsrv_fetch_array($stmt10, SQLSRV_FETCH_ASSOC)) {
	$MNG = $row10['MNG'];
	$WorkINo = $row10['WorkINo'];
	$ElementNo = $row10['ElementNo'];
	$ElementName = $row10['ElementName'];
	$CycleTime = $row10['CycleTime'];
	$Requestor = $row10['Requestor'];
}


$sql11 = "SELECT * FROM RequestUpdate WHERE RequestID = '$reqID'";
  $stmt11 = sqlsrv_query($conn2,$sql11);
  while($row11 = sqlsrv_fetch_array($stmt11, SQLSRV_FETCH_ASSOC)) {
    $original_requestor = $row11['Requestor'];
  }



$mail2 = new \PHPMailer\PHPMailer\PHPMailer();
$mail2->SMTPKeepAlive = true;
$mail2->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
$mail2->Subject = 'Request for Process Check ['. $id .']';
$mail2->AltBody = 'Please do not reply to this email. Thank you!';
$mail2->isSMTP();
$mail2->Host = 'smtp.brother.co.jp';
$mail2->SMTPAuth = FALSE;
$mail2->SMTPOptions = array(
	'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	)
); 
$mail2->Username = 'ZZPYPH04';
$mail2->Password = '.p&55worD';
$mail2->Port = 25;
$mail2->isHTML(true); // Set email format to HTML
$mail2->AddEmbeddedImage("../assets/img/phishingEmailNotice.png", "phishing-attach", "phishingEmailNotice.png");


$body = '<p style="font-size:16px;">You have new item <span style="color:green"><strong>Process Check Approval</strong></span></p>
<p style="font-size:16px;">For more details, please click the link <a href="http://apbiphbpswb01:8080/PDAUS/">Approval System</a> and login your credentials.</p>
<table style="font-family:arial, sans-serif; border-collapse: collapse; width:100%"><tr style="background-color:#dddddd;">
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Date</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">RequestID</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">WorkI</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">ElementNo</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">ElementName</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">CycleTime</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">SPV</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Requestor</th>
</tr>';
$body .= "<tr>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$today</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$id</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$WorkINo</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$ElementNo</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$ElementName</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$CycleTime</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$fullname</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$Requestor</td>
</tr>"; 

$mail2->Body = $body.'</table><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

// SEND TO ALL SPV AND SPV APPROVER
$sql3 = "SELECT * FROM Accounts WHERE AccountType ='SUPERVISOR' AND AccountStatus ='Active'";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {

	try {
		$mail2->AddCC($row3['EmailAddress']);
	} catch (Exception $e) {
		echo 'Invalid address skipped: ' . htmlspecialchars($row3['EmailAddress']) . '<br>';
		continue;
	}
}


// SEND TO WI-PIC AND ORIGINAL REQUESTOR
$sql6 = "SELECT * FROM Accounts WHERE FullName ='$Requestor' OR FullName ='$original_requestor'";
$stmt6 = sqlsrv_query($conn2,$sql6);
while($row6 = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {

	try {
		$mail2->AddCC($row6['EmailAddress']);
	} catch (Exception $e) {
		echo 'Invalid address skipped: ' . htmlspecialchars($row6['EmailAddress']) . '<br>';
		continue;
	}
}

// SEND TO MANAGER
$sql5 = "SELECT * FROM Accounts WHERE FullName ='$MNG'";
$stmt5 = sqlsrv_query($conn2,$sql5);
while($row5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
	try {
		$mail2->addAddress($row5['EmailAddress'], $row5['FullName']);
	} catch (Exception $e) {
		echo 'Invalid address skipped: ' . htmlspecialchars($row5['EmailAddress']) . '<br>';
		continue;
	}
}



try {
	$mail2->send();
} catch (Exception $e) {
	echo 'Mailer Error (' . htmlspecialchars($row5['EmailAddress']) . ') ' . $mail2->ErrorInfo . '<br>';
	$mail2->getSMTPInstance()->reset();
}
$mail2->clearAddresses();



?>