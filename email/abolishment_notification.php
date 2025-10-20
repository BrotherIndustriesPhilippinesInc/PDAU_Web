<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

$section_notify = $_GET['section'];


$sql = "SELECT * from SCI_MainData where Validity = 'Temporary' AND Section = '$section_notify' AND Status='Active' AND (CONVERT(date,ValidityDate) <= CONVERT(date, GETDATE() +3))";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$results = sqlsrv_query( $conn2, $sql , $params, $options );
$count = sqlsrv_num_rows( $results );

if ($count >=1) {



$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = '[BIPH_PDAU] Temporary SCI Abolition ['. $section_notify .' Section]';
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
				$mail->AddEmbeddedImage("../assets/img/warning.png", "request-type", "warning.png");


				$body = '<p style="font-size:18px;">Dear '.$section_notify.' Section,</p>
				<p style="font-size:18px;">Good Day!</p>
				<p style="font-size:18px;">
				The system detects that you have a Temporary SCI that will <span style="color:red">expire soon</span>.</br>
				 Please revise the document before the validity date, or the document will be automatically abolished.</p>

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

				while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
					$Section = $row['Section'];
					$SCINo = $row['SCINo'];
					$RevNo = $row['RevNo'];
					$Title = $row['Title'];
					$Model = $row['Model'];
					$Validity = $row['Validity'];
					$ValidityDate = $row['ValidityDate'];
					$SciNoFinal = $SCINo.'-'.$RevNo;

					$body .= '<tr>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;"><img src="cid:request-type" alt="Due Date" height="15">&nbsp;'.$ValidityDate.'</td>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Validity.'</td>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$SciNoFinal.'</td>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Section.'</td>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Title.'</td>
					<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Model.'</td>
					</tr>
					'; 
				}
				$mail->Body = $body.'</table><br><p style="font-size:18px;">To access the system, please click this <a href="http://'.$serverName.':'.$portNo.'/pdaus/">PDAUS System Link</a></p><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

				$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');


				$sqlEmail = "SELECT EmailAddress,FullName FROM Accounts WHERE Section = '$section_notify' AND SystemNo = 2 AND AccountStatus='Active'";
				$stmtEmail = sqlsrv_query($conn2,$sqlEmail);
				while($rowEmail = sqlsrv_fetch_array($stmtEmail, SQLSRV_FETCH_ASSOC)) {
					try {
						$mail->addAddress($rowEmail['EmailAddress'], $rowEmail['FullName']);
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
				<script type="text/javascript">
					window.close();
				</script>
				<?php

}
else{
	?>
	<script type="text/javascript">
		window.close();
	</script>
	<?php

}


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Abolishment Notification - Process Document Auto Updater</title>
    <link rel="icon" href="../assets/img/update.png" type="image/gif" sizes="16x16">
</head>
<body>
  <div style="display: flex;justify-content: center;align-content: center;">
   <img src="../assets/img/loading_pdau.gif" >
  </div>
  <div style="display: flex;justify-content: center;align-content: center;">
    <h2>System Abolishment Notification working. Please do not close.</h2>
  </div>

</body>
</html>

