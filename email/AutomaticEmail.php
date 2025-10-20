<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';
date_default_timezone_set('Asia/Singapore');
$today = date("F d, Y");
$today_link = date("Y-m-d");


$mail2 = new \PHPMailer\PHPMailer\PHPMailer();
$mail2->SMTPKeepAlive = true;
$mail2->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
$mail2->Subject = 'Daily Audit ['. $today .']';
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


$mail2->Body ='<p style="font-size:16px;">Please see below link of <strong>Daily Audit</strong> '.$today.' </p>
<p style="font-size:16px;">Click the link  to view <a href="http://apbiphbpswb01:8080/PDAUS/DailyAudit.php?date='.$today_link.'">Daily Audit</a>.</p>

<p style="font-size:16px;">Click the link  to view <a href="http://apbiphbpswb01:8080/PDAUS/ActivityResult.php?date='.$today_link.'">Activity Checklist Result</a>.</p>
<br>
<br>
<h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>
';


/*
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
*/
try {
		$mail2->addAddress('lemuel.delmundo@brother-biph.com.ph', 'Lemuel Del Mundo');
	} catch (Exception $e) {
		echo 'Invalid address skipped: ' . htmlspecialchars('lemuel.delmundo@brother-biph.com.ph') . '<br>';
	}

$mail2->addAddress('khentjosholivier.ocampo@brother-biph.com.ph', 'Josh');
$mail2->addAddress('belinda.belen@brother-biph.com.ph', 'MAm Bel');
$mail2->addAddress('kristina.parra@brother-biph.com.ph', 'Mam KC');


try {
	$mail2->send();
} catch (Exception $e) {
	echo 'Mailer Error (' . htmlspecialchars($row5['EmailAddress']) . ') ' . $mail2->ErrorInfo . '<br>';
	$mail2->getSMTPInstance()->reset();
}
$mail2->clearAddresses();



?>