<?php
require_once("../PhpMailer/src/PHPMailer.php");
require_once("../PhpMailer/src/SMTP.php");
require_once("../PhpMailer/src/Exception.php");

include '../global/conn.php';


$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = '[BIPH_PDAU] Request Approved - '.$RequestType.' ['. $requestID .']';
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


				$body = '<p style="font-size:18px;">Dear All,</p>
				<p style="font-size:18px;">Good Day!</p>
				<p style="font-size:18px;">Request for '.$RequestType.' SCI with RequestID ('.$requestID.') has now approved.</p>
				<p style="font-size:18px;">Please see below details for your reference:</p>
				<table style="font-family:Open Sans; border-collapse: collapse; width:100%">
				<tr style="background-color:#009">
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Request Date</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Requestor</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Section</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">SCI Number</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Title</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Model</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity Date</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Request Details</th>
				</tr>';
				$body .= '<tr>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$RequestDate.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Requestor.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$RequestSection.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$finalSCI.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Title.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Model.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$Validity.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$ValidityDate.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$RequestDetails.'</td>
				</tr>
				'; 
				$mail->Body = $body.'</table><br><p style="font-size:18px;">To Access the system, please click this <a href="http://'.$serverName.':'.$portNo.'/pdaus/global/requestController.php?reqID=0&control=login">PDAUS System Link</a>
				</p><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

				/*CC TO Approver*/
				$mail->AddCC($emailaddress);

				$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');

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

				$sql2 = "SELECT EmailAddress,FullName FROM Accounts WHERE UserADID = (select SPV_ADID from SCI_Approval WHERE RequestID = '$requestID')";
				$stmt2 = sqlsrv_query($conn2,$sql2);
				while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
					try {
						$mail->addAddress($row2['EmailAddress'], $row2['FullName']);
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