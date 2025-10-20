<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

/*$reqID = 'REQ-19';*/

$sql10 = "SELECT * FROM RequestUpdate WHERE RequestID = '$id'";
  $stmt10 = sqlsrv_query($conn2,$sql10);
  while($row10 = sqlsrv_fetch_array($stmt10, SQLSRV_FETCH_ASSOC)) {
    $Requestor = $row10['Requestor'];
    $SPVProcess = $row10['SPVProcess'];
  


$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = 'Request for Update: DENIED ['. $id .']';
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
				$mail->Username = 'ZZPYPH04';
				$mail->Password = '.p&55worD';
				$mail->Port = 25;
				$mail->isHTML(true); // Set email format to HTML
				$mail->AddEmbeddedImage("../assets/img/phishingEmailNotice.png", "phishing-attach", "phishingEmailNotice.png");


				$body = '<p style="font-size:16px;">Your Request for Update has been <span style="color:red"><strong>DENIED!</strong></span></p>
				<p style="font-size:16px;">For more details, click the <a href="\\\\apbiphsh07\\D0_ShareBrotherGroup\\PDAU Installer.bat">Process Document Auto Updater System</a> and login your credentials.</p>
				<table style="font-family:arial, sans-serif; border-collapse: collapse; width:100%"><tr style="background-color:#dddddd;">
				  <th style="border:1px solid #dddddd; text-align:left;padding:8px;">Date</th>
					<th style="border:1px solid #dddddd; text-align:left;padding:8px;">RequestID</th>
					<th style="border:1px solid #dddddd; text-align:left;padding:8px;">SPV</th>
					<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Status</th>
					<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Reason</th>
					</tr>';
				$body .= "<tr>
				<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$today</td>
				<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$id</td>
				<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$fullname</td>
				<td style='border:1px solid #dddddd; text-align:left;padding:8px; color:red'><b>Denied</b></td>
				<td style='border:1px solid #dddddd; text-align:left;padding:8px;'>$reqReason</td>
				</tr>"; 

				$mail->Body = $body.'</table><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';
			
					

			$sql3 = "SELECT * FROM Accounts WHERE AccountType ='SUPERVISOR' AND AccountStatus ='Active'";
			$stmt3 = sqlsrv_query($conn2,$sql3);
			while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {

				try {
					$mail->AddCC($row3['EmailAddress']);
				} catch (Exception $e) {
					echo 'Invalid address skipped: ' . htmlspecialchars($row3['EmailAddress']) . '<br>';
					continue;
				}
			}

			$sql2 = "SELECT * FROM Accounts WHERE FullName = '$requestor' ";
			$stmt2 = sqlsrv_query($conn2,$sql2);
			while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
				try {
					$mail->addAddress($row2['EmailAddress'], $row2['FullName']);
				} catch (Exception $e) {
					echo 'Invalid address skipped: ' . htmlspecialchars($row2['EmailAddress']) . '<br>';
					continue;
				}
			}

		try {
			$mail->send();
		} catch (Exception $e) {
			echo 'Mailer Error (' . htmlspecialchars($row2['EmailAddress']) . ') ' . $mail->ErrorInfo . '<br>';
			$mail->getSMTPInstance()->reset();
		}
		$mail->clearAddresses();
	}

?>