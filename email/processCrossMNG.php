<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

/*$reqID = 'REQ-19';*/

$sql10 = "SELECT * FROM ProcessCheck WHERE RequestID = '$id'";
$stmt10 = sqlsrv_query($conn2,$sql10);
while($row10 = sqlsrv_fetch_array($stmt10, SQLSRV_FETCH_ASSOC)) {
	$Requestor = $row10['Requestor'];
}

$sql11 = "SELECT * FROM RequestUpdate WHERE RequestID = '$id'";
$stmt11 = sqlsrv_query($conn2,$sql11);
while($row11 = sqlsrv_fetch_array($stmt11, SQLSRV_FETCH_ASSOC)) {
	$original_requestor = $row11['Requestor'];
}


$mail2 = new \PHPMailer\PHPMailer\PHPMailer();
$mail2->SMTPKeepAlive = true;
$mail2->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
$mail2->Subject = 'Request for Process Check Denied ['. $id .']';
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


$body = '<p style="font-size:16px;">Your Request for Update has been <span style="color:red"><strong>DENIED!</strong></span></p>
<p style="font-size:16px;">For more details, click the <a href="\\\\apbiphsh07\\D0_ShareBrotherGroup\\PDAU Installer.bat">Process Document Auto Updater System</a> and login your credentials.</p>
<table style="font-family:arial, sans-serif; border-collapse: collapse; width:100%"><tr style="background-color:#dddddd;">
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Date</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">RequestID</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Status</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Details</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Manager</th>
</tr>';
$body .= "<tr>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$today</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$id</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;color:red'><strong>Declined</strong></td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$reqReason</td>
<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$fullname</td>
</tr>"; 

$mail2->Body = $body.'</table><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';



//CC to ALL SPV
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

//CC to MANAGER PROCESSOR
$mail2->AddCC($emailaddress);

//CC to ORIGINAL REQUESTOR
$mail2->AddCC($original_requestor);



// SEND TO WI-PIC
$sql5 = "SELECT * FROM Accounts WHERE FullName ='$Requestor'";
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