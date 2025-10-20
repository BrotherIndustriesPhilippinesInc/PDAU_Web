<?php
require("../PhpMailer/src/PHPMailer.php");
require("../PhpMailer/src/SMTP.php");
require("../PhpMailer/src/Exception.php");

include '../global/conn.php';

/*$reqID = 'REQ-19';*/


$mail = new \PHPMailer\PHPMailer\PHPMailer();
				$mail->SMTPKeepAlive = true;
				$mail->setFrom('pdaus@brother-biph.com.ph', 'PDAUS');
				$mail->Subject = '[BIPH_PDAU] Password Reset';
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


				$body = '<p style="font-size:16px;">Your password has been <span style="color:red"><b>RESET</b></span> by '.$client_ip.' , '.$today.'</p>
				<p style="font-size:16px;">Please change your password immediately. Click this link <a href="http://'.$serverName.':'.$portNo.'/pdaus/reset-password.php?biph_id='.$biph_id.'">PDAUS Change Password</a> and update your password.</p>
				<br>
				<img alt="Phishing Notice" src="cid:phishing-attach"><br>
				<h4 style="color:red;">**Note: This is a system generated email. Please do not reply to this message. ***</h4>
				';

				$mail->Body = $body;


				try {
					$mail->AddCC('lemuel.delmundo@brother-biph.com.ph');
				} catch (Exception $e) {
					echo 'Invalid address skipped: ' . htmlspecialchars('lemuel.delmundo@brother-biph.com.ph') . '<br>';
				}
			
				/*$final_email = "lemuel.delmundo@brother-biph.com.ph";
				$biph_id = "09104";*/

				try {
					$mail->addAddress($final_email, $biph_id);
				} catch (Exception $e) {
					echo 'Invalid address skipped: ' . htmlspecialchars('lemuel.delmundo@brother-biph.com.ph') . '<br>';
				}

				/*$mail->addAttachment('../attachment/20230315925-WI0205-13681-00.PDF');*/
			

		try {
			$mail->send();
		} catch (Exception $e) {
			echo 'Mailer Error (' . htmlspecialchars('lemuel.delmundo@brother-biph.com.ph') . ') ' . $mail->ErrorInfo . '<br>';
			$mail->getSMTPInstance()->reset();
		}
		$mail->clearAddresses();



?>