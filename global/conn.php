<?php
$server_name = "apbiphdb23";
$connection = array("Database"=>"PDAUS", "UID"=>"saa", "PWD"=>"P@ssw0rd","CharacterSet" => "UTF-8");
$conn2 =sqlsrv_connect($server_name, $connection);



/*SQL SERVER CREDENTIAL (CHANGE THIS INCASE OF CHANGE OF SERVER)*/
$portal_server = "apbiphbpsdb02";
$portal_user = "CAS_access";
$portal_password = "@BIPH2024";
$portal_db = "Centralized_LOGIN_DB";

$connection = array("Database"=>$portal_db, "UID"=>$portal_user, "PWD"=>$portal_password);
$conn_portal =sqlsrv_connect($portal_server, $connection);



/*WEB SERVER INFORMATION*/
$portNo = $_SERVER['SERVER_PORT'];
$serverName = getenv('COMPUTERNAME');


/*EMAIL-SMTP INFORMATION*/

$smtp_username = "ZZPYPH04";
$smtp_password = ".p&55worD";
$smtp_port = 25;



/*DATE TODAY GMT +8*/

date_default_timezone_set('Asia/Singapore');
$today_formated = date("Y-m-d");

$time_now = date("h:i:s A");
$today = date("F d, Y h:i A", time());
$today_noTime = date("F d, Y");

/*SYSTEM VERSION*/

$sysVersion = "1.1";

$next_due_date = date('Y-m-d', strtotime("+30 days"));

$ip_client = $_SERVER['REMOTE_ADDR'];

$client_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$client_ip = substr($client_ip, 0,10);






?>