<?php 
date_default_timezone_set('Asia/Singapore');
$time_now = date("h:i:s A");

if ($time_now == "09:45:00 AM") {

	include '../email/AutomaticEmail.php';
	?>
	<script type="text/javascript">
		function alertTimeout(mymsg,mymsecs)
		{
			var myelement = document.createElement("div");
			myelement.setAttribute("style","background-color: red;color:white; width: 1000px;height: 600px;position: absolute;top:0;bottom:0;left:0;right:0;margin:auto;border: 4px solid black;font-family:arial;font-size:40px;font-weight:bold;display: flex; align-items: center; justify-content: center; text-align: center;");
			myelement.innerHTML = mymsg;
			setTimeout(function(){
				myelement.parentNode.removeChild(myelement);
			},mymsecs);
			document.body.appendChild(myelement);
		}
		alertTimeout("Auto Email Sending<br>This alert will auto-close after 5 seconds",5000)
	</script>
	<?php
}
echo $time_now;

?>