<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");


$sqlEmail = "SELECT * from SCI_MainData where Validity = 'Temporary' AND Section = '$section' AND Status='Active' AND (CONVERT(date,ValidityDate) <= CONVERT(date, GETDATE()))";
$stmtEmail = sqlsrv_query($conn2,$sqlEmail);

$mail = new \PHPMailer\PHPMailer\PHPMailer();
$mail->SMTPKeepAlive = true;
$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
$mail->Subject = '[BIPH_PDAU] System Abolished ['. $section .' Section]';
$mail->AltBody = 'Please do not reply to this email. Thank you!';
$mail->isSMTP();
$mail->Host = 'smtp.brother.co.jp';
$mail->SMTPAuth = FALSE;
$mail->SMTPOptions = array(
	'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	)
); 
$mail->Username = $smtp_username;
$mail->Password = $smtp_password;
$mail->Port = $smtp_port;
$mail->isHTML(true); // Set email format to HTML
$mail->AddEmbeddedImage("../assets/img/phishingEmailNotice.png", "phishing-attach", "phishingEmailNotice.png");
$mail->AddEmbeddedImage("../assets/img/abolish.png", "request-type", "abolish.png");


$body = '<p style="font-size:18px;">Dear '.$section.' Section,</p>
<p style="font-size:18px;">Good Day!</p>
<p style="font-size:18px;">
This is to inform you that the following Temporary SCI was abolished by system due to the <span style="color:red">expiration</span> of Validity Date.
 </br>You can check the abolished data in <b>SCI Documents -> Abolished Data</b>.</p>

<p style="font-size:18px;">Date: '.$today.'</p>
<p style="font-size:18px;">Total SCI Document: '.$count.' Documents</p>
<table style="font-family:Open Sans; border-collapse: collapse; width:100%">
<tr style="background-color:#009">
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity Until</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">SCI Number</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Section</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Title</th>
<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Model</th>
</tr>';

while($rowEmail = sqlsrv_fetch_array($stmtEmail, SQLSRV_FETCH_ASSOC)) {
	$SectionEmail = $rowEmail['Section'];
	$SCINoEmail = $rowEmail['SCINo'];
	$RevNoEmail = $rowEmail['RevNo'];
	$TitleEmail = $rowEmail['Title'];
	$ModelEmail = $rowEmail['Model'];
	$ValidityEmail = $rowEmail['Validity'];
	$ValidityDateEmail = $rowEmail['ValidityDate'];
	$SciNoFinalEmail = $SCINoEmail.'-'.$RevNoEmail;

	$body .= '<tr>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;"><img src="cid:request-type" alt="Due Date" height="15">&nbsp;'.$ValidityDateEmail.'</td>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$ValidityEmail.'</td>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$SciNoFinalEmail.'</td>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$SectionEmail.'</td>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$TitleEmail.'</td>
	<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$ModelEmail.'</td>
	</tr>
	'; 
}
$mail->Body = $body.'</table><br><p style="font-size:18px;">To access the system, please click this <a href="http://'.$serverName.':'.$portNo.'/pdaus/">PDAUS System Link</a></p><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');


$sqlReceiver = "SELECT EmailAddress,FullName FROM Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountStatus='Active'";
$stmtReceiver = sqlsrv_query($conn2,$sqlReceiver);
while($rowReceiver = sqlsrv_fetch_array($stmtReceiver, SQLSRV_FETCH_ASSOC)) {
	try {
		$mail->addAddress($rowReceiver['EmailAddress'], $rowReceiver['FullName']);
	} catch (Exception $e) {
		echo 'Invalid address skipped: ' . htmlspecialchars('bpsapplicationsupport@brother-biph.com.ph') . '<br>';
		continue;
	}
}

try {
	$mail->send();
} catch (Exception $e) {
	echo 'Mailer Error (' . htmlspecialchars('bpsapplicationsupport@brother-biph.com.ph') . ') ' . $mail->ErrorInfo . '<br>';
	$mail->getSMTPInstance()->reset();
}
$mail->clearAddresses();

?>

