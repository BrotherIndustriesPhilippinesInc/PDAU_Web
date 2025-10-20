<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

$details_final = str_replace("''","'",$details_final);

$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = '[BIPH_PDAU] Request for Approval - '.$sciType.' ['. $requestID .']';
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


				$body = '<p style="font-size:18px;">Dear '.$select_spv_final.',</p>
				<p style="font-size:18px;">Good Day!</p>
				<p style="font-size:18px;">'.$fullname.' from '.$section.', request for '.$sciType.' SCI with RequestID ('.$requestID.') .</p>
				<p style="font-size:18px;">Please see below details for your reference:</p>
				<table style="font-family:Open Sans; border-collapse: collapse; width:100%">
				<tr style="background-color:#009">
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Request Date</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">SCI Number</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Title</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Model</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Validity Date</th>
				<th style="border:1px solid #dddddd; text-align:left;padding:8px;">Request Details</th>
				</tr>';
				$body .= '<tr>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$today.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$sciFinal.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$title_final.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$model_final.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$validity_final.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$final_validity_date.'</td>
				<td style="border:1px solid #dddddd; text-align:left;padding:8px;">'.$details_final.'</td>
				</tr>
				'; 
				$mail->Body = $body.'</table><br><p style="font-size:18px;">For Approval, please click this <a href="http://'.$serverName.':'.$portNo.'/pdaus/global/requestController.php?reqID='.$requestID.'&control=approval">PDAUS System Link</a></p><br><img alt="Phishing Notice" src="cid:phishing-attach"><br><h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>';

				/*CC TO Requestor*/
				$mail->AddCC($emailaddress);

				$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');

				$sql = "SELECT EmailAddress FROM Accounts WHERE FullName = '$select_spv_final'";
				$stmt = sqlsrv_query($conn2,$sql);
				while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					try {
						$mail->addAddress($row['EmailAddress'], $select_spv);
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