<?php
require_once '../global/conn.php';
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=UserAccounts-".$today_formated.".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	
	
	$output = "";
	
	$output .="
		<table>
			<thead>
				<tr>
					<th>EmployeeID</th>
					<th>ADID</th>
					<th>FullName</th>
					<th>Department</th>
					<th>Section</th>
					<th>Email</th>
					<th>Account Type</th>
					<th>Status</th>
				</tr>
			<tbody>
	";
	
	$sql = "SELECT * FROM Accounts WHERE SystemNo = 2 ORDER BY BIPH_ID ASC ";
	$stmt = sqlsrv_query($conn2,$sql);
	while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
	{ 

	$output .= "
				<tr>
					<td>".$row['BIPH_ID']."</td>
					<td>".$row['UserADID']."</td>
					<td>".$row['FullName']."</td>
					<td>".$row['Department']."</td>
					<td>".$row['Section']."</td>
					<td>".$row['EmailAddress']."</td>
					<td>".$row['AccountType']."</td>
					<td>".$row['AccountStatus']."</td>
				</tr>
	";
	}

	
	$output .="
			</tbody>
			
		</table>
	";
	
	echo $output;
	echo '<script type="text/javascript">
alert("Hey Joe!");
</script>';
	
?>
