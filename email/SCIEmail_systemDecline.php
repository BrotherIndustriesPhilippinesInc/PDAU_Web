<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

$requestID = $_GET['reqID'];

$sql = "SELECT * FROM SCI_Request WHERE RequestID = '$requestID'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	$id = $row['ID'];
	$RequestDate = $row['RequestDate'];
	$RequestID = $row['RequestID'];
	$RequestType = $row['RequestType'];
	$SCINo = $row['SCINo'];
	$RevNo = $row['RevNo'];
	$Title = $row['Title'];
	$Model = $row['Model'];
	$SPV = $row['SPV'];
	$MGR = $row['MGR'];
	$Validity = $row['Validity'];
	$ValidityDate = $row['ValidityDate'];
	$RequestDetails = $row['RequestDetails'];
	$Requestor = $row['Requestor'];
	$RequestSection = $row['RequestSection'];
	$SCIForProcess = $row['SCIForProcess'];
	$Status = $row['Status'];
}

$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = '[BIPH_PDAU] System Declined - '.$RequestType.' ['. $requestID .']';
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


				$body = '<p style="font-size:18px;">Dear '.$Requestor.',</p>
				<p style="font-size:18px;">Good Day!</p>
				<p style="font-size:18px;">Your request for '.$RequestType.' SCI with RequestID ('.$requestID.') has been <span style="color:red"><b>Declined by System</b></span>.</p>
				<p style="font-size:18px;">Please see below details for your reference:</p>
				<table style="font-family:Open Sans; border-collapse: collapse; width:100%">
				<tr style="background-color:#009">
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Declined Date</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">RequestID</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Declined By</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Position</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Reason</th>
				</tr>';
				$body .= '<tr>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$today.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$requestID.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">System</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">-</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">System Declined due to wrong template. Please use the system template.</td>
				</tr>
				'; 
				$mail->Body = $body.'</table><br><p style="font-size:18px;">To re-submit or cancel request, please click this <a href="http://'.$serverName.':'.$portNo.'/pdaus/global/requestController.php?reqID='.$requestID.'&control=decline">PDAUS System Link</a></p><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

				/*CC TO Approver*/
				$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');
				

				// CC TO SPV
				$sql2 = "SELECT EmailAddress,FullName FROM Accounts WHERE FullName = (select SPV from SCI_Approval WHERE RequestID = '$requestID')";
				$stmt2 = sqlsrv_query($conn2,$sql2);
				while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
					try {
						$mail->addAddress($row2['EmailAddress'], $row2['FullName']);
					} catch (Exception $e) {
						echo 'Invalid address skipped: ' . htmlspecialchars('bpsapplicationsupport@brother-biph.com.ph') . '<br>';
						continue;
					}
				}

				// SEND TO REQUESTOR
				$sql = "SELECT EmailAddress, FullName FROM Accounts WHERE UserADID = (select Requestor_ADID from SCI_Approval WHERE RequestID = '$requestID')";
				$stmt = sqlsrv_query($conn2,$sql);
				while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					try {
						$mail->addAddress($row['EmailAddress'], $row['FullName']);
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
	function closeForm() {
		window.close();
	}
	setInterval(closeForm, 3000); 
</script>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System Declined - Process Document Auto Updater</title>
    <link rel="icon" href="../assets/img/update.png" type="image/gif" sizes="16x16">
</head>
<body>
  <div style="display: flex;justify-content: center;align-content: center;">
   <img src="../assets/img/loading_pdau.gif" >
  </div>
  <div style="display: flex;justify-content: center;align-content: center;">
    <h2>System Decline working. Please do not close.</h2>
  </div>

</body>
</html>