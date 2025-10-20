<link rel="stylesheet" href="../assets/css/cdnjs.cloudflare.com_ajax_libs_sweetalert_1.1.3_sweetalert.css">
<script src="../assets/js/cdnjs.cloudflare.com_ajax_libs_sweetalert_1.1.3_sweetalert-dev.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"> -->
<?php
session_start();
include '../global/conn.php';
include '../global/userInfo.php';
$function = $_GET['function'];
date_default_timezone_set('Asia/Singapore');
$today = date("F d, Y h:i A", time());

#LOGIN
if ($function == 'login') {

/*  $biph_id = $_POST['biph_id'];
  $mypassword = $_POST['mypassword'];*/

$reqID = $_GET['reqID'];
$control = $_GET['control'];
$username = $_GET['username'];


$sql = "SELECT * FROM Accounts WHERE BIPH_ID = '$username' AND AccountStatus = 'Active' ";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn2, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );

if ($row_count != 0) {
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $systemNo = $row['SystemNo'];
  $accountstatus = $row['AccountStatus'];
  $accounttype = $row['AccountType'];
  $changePass = $row['ChangePassMode'];
}


if ($systemNo == 1) {
  //ACCOUNT TYPE IS NOT SPV OR MGR
  if ($accounttype == 'SUPERVISOR' || $accounttype == 'MANAGER') {
    $_SESSION['pdau_id'] = $username;
    header('Location:../forms/dashboard.php');
  }
  // ACCOUNT TYPE SPV OR MGR
  else{
    ?>
    <script>
      setTimeout(function() {
        swal({
          text: 'Account Type is not Authorized. Please ask for support to your Admin or BPS. Thank you.',
          title: "Login Error", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../index.php?username=<?php echo $username; ?>";
        });
      }, 100);
    </script>
    <?php
  }
}

//FOR P-TOUCH SECTION
elseif ($systemNo == 2) {
  $_SESSION['pdau_id'] = $username;

  if ($control == "login") {
    header('Location:../forms/dashboard-sci.php');
  }
  else if ($control == "approval") {
    if ($reqID == 0 || $reqID == null) {
      header('Location:../forms/sciForApproval.php');
    }
    else{
      header('Location:../forms/sciForApproval-details.php?reqID='.$reqID.'');
    }
  }
  else if ($control == "decline") {
    header('Location:../forms/dashboard-sci.php');
  }

// insert User Logins

  $query2 = "INSERT INTO  SCI_UserLogs(BIPH_ID,IP_Address,DateTimeLog) VALUES ('$biph_id','$client_ip','$today')";
  $results2 = sqlsrv_query($conn2,$query2);
}

}

  //WRONG USERNAME OR PASSWORD OR NO WEB ACCESS
else{
   ?>
      <script>
      setTimeout(function() {
        swal({
          text: 'BIPH ID not exist. Please check your inputs and try again. Thank you.',
          title: "Login Error", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
           window.location = "../index.php?reqID=<?php echo $reqID ?>&control=<?php echo $control ?>";
        });
      }, 100);
    </script>
      <?php
    }
}


#ERROR LOGIN
else if ($function == 'errorLogin') {


  $reqID = $_GET['reqID'];
  $control = $_GET['control'];
  $username = $_GET['username'];
?>
<script>
      setTimeout(function() {
        swal({
          text: 'Please Login to I-PORTAL first, then click the RE-LOGIN button.',
          title: "Login Failed", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
           window.location = "../index.php?reqID=<?php echo $reqID ?>&control=<?php echo $control ?>";
        });
      }, 100);
    </script>
<?php

}

#VISITOR ACCOUNT

elseif ($function == 'visitor') {
  $_SESSION['pdau_id'] = "99";
  header('Location:../forms/dashboard-sci.php');
}


### APPROVE REQUEST ###
else if ($function == 'requestApprove') {

$reqID = $_GET['reqID'];

$query = "UPDATE RequestUpdate SET Status = 'CLOSED', SPVProcess='$fullname',SPVDate='$today', Location='WI-PIC',RequestWorkIStat='No' WHERE RequestID = '".$reqID."'";
$results = sqlsrv_query($conn2,$query);

$query1 = "UPDATE RequestAttachment SET Status = 'CLOSED', SPVProcess='$fullname' WHERE RequestID = '".$reqID."' AND Status = 'OPEN'";
$results1 = sqlsrv_query($conn2,$query1);

$query2 = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$reqID','REQUEST APPROVED','$fullname')";
$results2 = sqlsrv_query($conn2,$query2);

if ($results) {
  include ('../email/requestApprove.php');

  ?>
   <script>
      setTimeout(function() {
        swal({
          text: 'Request Approval Success',
          title: "Request Approval", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "Ok",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../RequestForApproval.php";
        });
      }, 100);
    </script>
  <?php
}
else{
  ?>
  <script>
    setTimeout(function() {
      swal({
        text: 'Request Approval Failed! Please contact your admin or BPS Section for support.',
        title: "Request Approval", 
        type: "error",   
        showConfirmButton: true,
        confirmButtonText: "Ok",   
        closeOnConfirm: true 
      }, function(){
        window.location = "../RequestForApproval.php";
      });
    }, 100);
  </script>
  <?php
}
}

## DECLINE REQUEST##

else if ($function == 'reqDecline') {

  $id = $_GET['id'];

  $attachID = $_POST['attachID'];
  $reqReason = $_POST['reqReason'];
  $requestor = $_POST['requestor'];

$query1 = "UPDATE RequestAttachment SET Status = 'DENIED',SPVProcess='$fullname', SPVDate = '$today',SPVRemarks='$reqReason',SPVAttachment = '-' where RequestID = '$id' AND ID = '$attachID'";
$results1 = sqlsrv_query($conn2,$query1);

$query = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$id','REQUEST DENIED','$fullname')";
$results = sqlsrv_query($conn2,$query);

$query2 = "UPDATE RequestUpdate SET Status = 'DENIED', SPVProcess='$fullname',SPVDate='$today' where RequestID = '".$id."'";
$results2 = sqlsrv_query($conn2,$query2);

/*$query3 = "DELETE FROM  RequestTemp WHERE RequestID = '".$id."'";
$results3 = sqlsrv_query($conn2,$query3);*/



if ($results2) {
  include '../email/requestDecline.php';
  ?>
     <script>
      setTimeout(function() {
        swal({
          text: 'Decline Success',
          title: "Request Decline", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "Ok",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../RequestForApproval.php";
        });
      }, 100);
    </script>
  <?php
}
else{
  ?>
   <script>
    setTimeout(function() {
      swal({
        text: 'Request Approval Failed! Please contact your admin or BPS Section for support.',
        title: "Request Approval", 
        type: "error",   
        showConfirmButton: true,
        confirmButtonText: "Ok",   
        closeOnConfirm: true 
      }, function(){
        window.location = "../RequestForApproval.php";
      });
    }, 100);
  </script>
  <?php
}

}

#### UPDATE PASSWORD ###

elseif ($function == 'myPassword') {
 $id = $_GET['userID'];
 $newpass = $_POST['renewPassword'];

$query2 = "UPDATE Accounts SET SystemPassword = '$newpass' where BIPH_ID = '".$id."'";
$results2 = sqlsrv_query($conn2,$query2);

if ($results2) {
  ?>
  <script type="text/javascript">
    alert("Update password success.");
    window.location.replace("../index.php?username=<?php echo $BIPH_ID?>");
  </script>
  <?php
}
else{
  ?>
   <script type="text/javascript">
    alert("System Detect problem. Please contact your BPS for support.");
   window.location.replace("../myProfile.php");
  </script>
  <?php
}
}

###############################################  PROCESS APPROVE  ##########################################################

else if ($function == 'processApprove') { 

$id = $_GET['id'];
$user = $_GET['user'];


## SPV APPROVAL ##
if ($user=="SUPERVISOR") {   
  $query = "UPDATE ProcessCheck SET Location='MNG' WHERE RequestID = '".$id."'";
  $results = sqlsrv_query($conn2,$query);

  $query1 = "UPDATE ProcessAttachment SET  SPV='$fullname',SPVDate='$today' WHERE RequestID = '".$id."'";
  $results1 = sqlsrv_query($conn2,$query1);

  $query2 = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$id','REQUEST APPROVED BY SUPERVISOR','$fullname')";
  $results2 = sqlsrv_query($conn2,$query2);
   //EMAIL NOTIFICATION HERE
  include '../email/processCheckSPV.php';
?>
<script>
  setTimeout(function() {
    swal({
      text: 'Process Checking Approval Success',
      title: "Process Checking Approval", 
      type: "success",   
      showConfirmButton: true,
      confirmButtonText: "Ok",   
      closeOnConfirm: true 
    }, function(){
      window.location = "../ProcessChecking.php";
    });
  }, 100);
</script>

<?php
}
 ## MANAGER APPROVAL ##
else { 
  $query = "UPDATE ProcessCheck SET Location='-',Status='CLOSED' WHERE RequestID = '".$id."'";
  $results = sqlsrv_query($conn2,$query);

  $query1 = "UPDATE ProcessAttachment SET  MNG='$fullname',MNGDate='$today' WHERE RequestID = '".$id."'";
  $results1 = sqlsrv_query($conn2,$query1);

  $query2 = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$id','REQUEST APPROVED BY MANAGER','$fullname')";
  $results2 = sqlsrv_query($conn2,$query2);

  //INSERT PROCESS OF UPDATING IN MAIN DATA 

  $sql = "SELECT * FROM RequestUpdate WHERE RequestID = '".$id."'";
  $stmt = sqlsrv_query($conn2,$sql);
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $TypeTransfer = $row['TypeTransfer'];
    $MultipleModel = $row['MultipleModel'];
    $Model_single = $row['Model'];
    $Process_single = $row['Process'];
    $ProcessNo_single = $row['ProcessNo'];
    $SeriesNo_single = $row['SeriesNo'];
    
  }
     $sql3 = "SELECT * FROM ProcessCheck WHERE RequestID = '".$id."'";
        $stmt3 = sqlsrv_query($conn2,$sql3);
        while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
          $WorkINo = $row3['WorkINo'];
          $ElementNo = $row3['ElementNo'];
          $ElementName = $row3['ElementName'];
          $Requestor = $row3['Requestor'];
          $CycleTime = $row3['CycleTime'];
  }

         $sql4 = "SELECT * FROM ProcessAttachment WHERE RequestID = '".$id."' AND Status = 'OPEN'";
        $stmt4 = sqlsrv_query($conn2,$sql4);
        while($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
          $WorkIAttachment = $row4['WindowAttach'];
        }

    if ($TypeTransfer == "New") {
      if ($MultipleModel == "Yes") {

        //SELECT TEMPORARY TABLE
        $sql1 = "SELECT * FROM RequestTemp WHERE RequestID = '".$id."'";
        $stmt1 = sqlsrv_query($conn2,$sql1);
        while($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
          $ID = $row1['ID'];
          $Model = $row1['Model'];
          $Process = $row1['Process'];
          $ProcessNo = $row1['ProcessNo'];
          $SeriesNo = $row1['SeriesNo'];

            $sql2 = "SELECT MAX(SeriesNo) as LastSeries FROM MasterData WHERE Model = '$Model' AND Process = '$Process' AND ProcessNo = '$ProcessNo'";
            $stmt2 = sqlsrv_query($conn2,$sql2);
            while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
              $LastSeries = $row2['LastSeries'];

              $query3 = "UPDATE MasterData SET SeriesNo=SeriesNo + 1 WHERE SeriesNo BETWEEN '$SeriesNo' AND '$LastSeries' AND Model = '$Model' AND Process = '$Process' AND ProcessNo = '$ProcessNo'";
              $results3 = sqlsrv_query($conn2,$query3);

              # ADDED BY L.DEL MUNDO 03/14/2023
              $WorkIAttachment = str_replace(':8080\pdaus','',$WorkIAttachment);
              $ext  = (new SplFileInfo($WorkIAttachment))->getExtension(); 
              $destination = '\\\apbiphsh04\B1_BIPHCommon\16_Printer\PDAU\AttachmentFolder\MasterData\New'.''.'\\'.''.$WorkINo.'.'.$ext;
              rename($WorkIAttachment, $destination);
              unlink($WorkIAttachment);

              //inserting to Database
              # UPDATED BY L.DEL MUNDO 05/25/2023
              $query2 = "INSERT INTO  MasterData(Model,Process,ProcessNo,ElementName,ElementNo,WorkINo,SeriesNo,WorkIFilename,Uploaded_by,Uploaded_date,CycleTime,Target1,Target2) VALUES ('$Model','$Process','$ProcessNo','$ElementName','$ElementNo','$WorkINo','$SeriesNo','$destination','$Requestor','$today','$CycleTime','34','36')";
              $results2 = sqlsrv_query($conn2,$query2);
          }
        }

      }
      else{ //MULTIPLE MODEL = NO

        $sql2 = "SELECT MAX(SeriesNo) as LastSeries FROM MasterData WHERE Model = '$Model_single' AND Process = '$Process_single' AND ProcessNo = '$ProcessNo_single'";
        $stmt2 = sqlsrv_query($conn2,$sql2);
        while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
          $LastSeries = $row2['LastSeries'];

          $query3 = "UPDATE MasterData SET SeriesNo=SeriesNo + 1 WHERE SeriesNo BETWEEN '$SeriesNo_single' AND '$LastSeries' AND Model = '$Model_single' AND Process = '$Process_single' AND ProcessNo = '$ProcessNo_single'";
          $results3 = sqlsrv_query($conn2,$query3);

         # ADDED BY L.DEL MUNDO 03/14/2023
          $WorkIAttachment = str_replace(':8080\pdaus','',$WorkIAttachment);
          $ext  = (new SplFileInfo($WorkIAttachment))->getExtension(); 
          $destination = '\\\apbiphsh04\B1_BIPHCommon\16_Printer\PDAU\AttachmentFolder\MasterData\New'.''.'\\'.''.$WorkINo.'.'.$ext;
          rename($WorkIAttachment, $destination);
          unlink($WorkIAttachment);

              //inserting to Database
          # UPDATED BY L.DEL MUNDO 05/25/2023
          $query2 = "INSERT INTO  MasterData(Model,Process,ProcessNo,ElementName,ElementNo,WorkINo,SeriesNo,WorkIFilename,Uploaded_by,Uploaded_date,CycleTime,Target1,Target2) VALUES ('$Model_single','$Process_single','$ProcessNo_single','$ElementName','$ElementNo','$WorkINo','$SeriesNo_single','$destination','$Requestor','$today','$CycleTime','34','36')";
          $results2 = sqlsrv_query($conn2,$query2);

          }
        }
      
    }
    else{ //TYPE TRANSFER = Revision

      # ADDED BY L.DEL MUNDO 03/14/2023
      $WorkIAttachment = str_replace(':8080\pdaus','',$WorkIAttachment);
      $ext  = (new SplFileInfo($WorkIAttachment))->getExtension(); 
      $destination = '\\\apbiphsh04\B1_BIPHCommon\16_Printer\PDAU\AttachmentFolder\MasterData\Revision'.''.'\\'.''.$WorkINo.'.'.$ext;
      rename($WorkIAttachment, $destination);
      unlink($WorkIAttachment);


      if ($CycleTime!='-') {
       $query3 = "UPDATE MasterData SET WorkIFilename =' $destination', CycleTime='$CycleTime',Uploaded_by='$Requestor',Uploaded_date='$today' WHERE WorkINo = '$WorkINo'";
       $results3 = sqlsrv_query($conn2,$query3);
     }
     else{

      $query3 = "UPDATE MasterData SET WorkIFilename =' $destination',Uploaded_by='$Requestor',Uploaded_date='$today' WHERE WorkINo = '$WorkINo'";
       $results3 = sqlsrv_query($conn2,$query3);
     }
  }

  //EMAIL NOTIFICATION HERE
     include '../email/processCheckMNG.php';
   ?>
     <script>
      setTimeout(function() {
        swal({
          text: 'Process Checking Approval Success',
          title: "Process Checking Approval", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "Ok",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../ProcessChecking.php";
        });
      }, 100);
    </script>
    <?php
}
}


/*PROCESS DECLINE*/

elseif ($function == "processDecline") {
  $id = $_GET['id'];
  $user = $_GET['user'];
  $reqReason = $_POST['reqReason'];

  $attachment = time() . '-' . $_FILES["attachment"]["name"];

  $target_dir = "../attachment/";
/*  $directory = */
  $target_file = $target_dir . basename($attachment);

  $newDirectory = "attachment/";
  $newTarget = $newDirectory . basename($attachment);

  $windowAttach = "\\\apbiphbpswb01\attachment\\";
  $windowTarget = $windowAttach . basename($attachment);

  move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);


### SPV DECLINE  ###
  if ($user == "SUPERVISOR") {
    $query2 = "UPDATE ProcessCheck SET Status = 'DENIED',Location='WI-PIC',Decline='SPV' where RequestID = '".$id."'";
    $results2 = sqlsrv_query($conn2,$query2);

    $query1 = "UPDATE ProcessAttachment SET SPV = '$fullname',SPVDate='$today', SPVRemarks ='$reqReason',SPVAttach= '$windowTarget',Status='DENIED' where RequestID = '$id'";
    $results1 = sqlsrv_query($conn2,$query1);

    $query = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$id','REQUEST DENIED BY SUPERVISOR','$fullname')";
    $results = sqlsrv_query($conn2,$query);

    ##Email Notification
    include '../email/processCrossSPV.php';
  }
### MNG DECLINE  ###
  else{
    $query2 = "UPDATE ProcessCheck SET Status = 'DENIED',Location='WI-PIC',Decline='MNG' where RequestID = '".$id."'";
    $results2 = sqlsrv_query($conn2,$query2);

    $query1 = "UPDATE ProcessAttachment SET MNG = '$fullname',MNGDate='$today', MNGRemarks ='$reqReason',MNGAttach= '$windowTarget',Status='DENIED' where RequestID = '$id'";
    $results1 = sqlsrv_query($conn2,$query1);

    $query = "INSERT INTO  RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$id','REQUEST DENIED BY MANAGER','$fullname')";
    $results = sqlsrv_query($conn2,$query);

    include '../email/processCrossMNG.php';
  }
  ?>
    <script>
      setTimeout(function() {
        swal({
          text: 'Decline Success',
          title: "Process Checking Approval", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "Ok",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../ProcessChecking.php";
        });
      }, 100);
    </script>
    <?php
}

elseif ($function == "move_file") {

    $sql4 = "SELECT * FROM ProcessAttachment WHERE RequestID = 'REQ-23' AND Status = 'OPEN'";
        $stmt4 = sqlsrv_query($conn2,$sql4);
        while($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
          $WorkIAttachment = $row4['WindowAttach'];
        }

            $WorkIAttachment = str_replace(':8080\pdaus','',$WorkIAttachment);
      
              $ext  = (new SplFileInfo($WorkIAttachment))->getExtension(); 
              $destination = '\\\apbiphsh04\B1_BIPHCommon\16_Printer\PDAU\AttachmentFolder\MasterData\New'.''.'\\'.''.$WorkINo.'.'.$ext;
              if( !rename($WorkIAttachment, $destination) ) { 
                echo "File can't be copied! \n"; 
                echo $WorkIAttachment;
              } 
              else { 
                echo "File has been copied! \n"; 
              }
              unlink($WorkIAttachment);

}


















######################################################  SCI DOCUMENT PROCESS  ##########################################################

### FORGOT PASSWORD  ###
elseif ($function == "forgotPassword") {
 
 $final_email = $_POST['valid_email'].$_POST['domain_name'];

 /*echo $final_email;*/

 $sql_reset = "SELECT * FROM Accounts WHERE EmailAddress = '$final_email' AND AccountStatus = 'Active'";
 $params_reset = array();
 $options_reset =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
 $stmt_reset = sqlsrv_query( $conn2, $sql_reset , $params_reset, $options_reset );
 $row_reset = sqlsrv_num_rows( $stmt_reset );


 if ($row_reset >=1) {

/*  $client_ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  $client_ip = substr($client_ip, 0,10);*/

  while($row = sqlsrv_fetch_array($stmt_reset, SQLSRV_FETCH_ASSOC)) {
    $biph_id = $row['BIPH_ID'];
    $webAccess = $row['WebAccess'];
  }


  /*ALLOWED TO RESET PASSWORD*/
  if ($webAccess == 1) {
    $query = "UPDATE Accounts SET ChangePassMode = 'YES' WHERE BIPH_ID = '".$biph_id."'";
    $results = sqlsrv_query($conn2,$query);
    include '../email/resetPassword.php';
  ?>
   <script>
      setTimeout(function() {
        swal({
          text: 'Please check your Email to reset your password. Thank you.',
          title: "RESET PASSWORD SUCCESS", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../index.php";
        });
      }, 100);
    </script>
  <?php
  }

  /*NOT ALLOWED TO RESET PASSWORD*/
  else
  {
    ?>
    <script>
      setTimeout(function() {
        swal({
          text: 'Your account does not have access to reset password. Please contact your admin or BPS for support. Thank you.',
          title: "Reset Password Failed ", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forgot-password.php";
        });
      }, 100);
    </script>
    <?php
  }

}
else{
  ?>
   <script>
      setTimeout(function() {
        swal({
          text: 'Email does not exist. Please check your inputs and try again or contact your admin or BPS for support.',
          title: "Reset Password Failed", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forgot-password.php";
        });
      }, 100);
    </script>
  <?php
}

}



### CHANGE PASSWORD  ###

elseif ($function == "changePassword") {

  $biph_id = $_GET['biph_id'];
  $new_pass = $_POST['re_password'];
 
 $query = "UPDATE Accounts SET ChangePassMode = 'NO', SystemPassword = '$new_pass' WHERE BIPH_ID = '".$biph_id."'";
 $results = sqlsrv_query($conn2,$query);

  ?>
  <script>
      setTimeout(function() {
        swal({
          text: 'Your password has been changed!',
          title: "Change Password Success", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../index.php?username=<?php echo $biph_id; ?>";
        });
      }, 100);
    </script>
  <?php

}



### NEW ACCOUNT  ###

elseif ($function == "newAccount") {

  $biph_id = $_POST['biph_id'];
  $adid_new = $_POST['adid'];
  $fullname_new = $_POST['fullname'];
  $dept_new = $_POST['dept'];
  $section_new = $_POST['section'];
  $position_new = $_POST['position'];
  $emailadd_new = $_POST['emailadd'];
  $accountCode = $_POST['accountCode'];

  $biph_id = strtoupper($biph_id);


  if ($accountCode == 'Yes') {
    $accountCode = 1;
  }
  else{
    $accountCode = 0;
  }
 
$query2 = "INSERT INTO  Accounts(BIPH_ID,UserADID,FullName,Department,Section,EmailAddress,AccountType,SystemPassword,AccountStatus,ChangePassMode,RegisterDate,RegisterPIC,SystemNo,WebAccess,AccountCode) VALUES ('$biph_id','$adid_new','$fullname_new','$dept_new','$section_new','$emailadd_new','$position_new','biph0301','Active','YES','$today','$fullname',2,1,'$accountCode')";
$results2 = sqlsrv_query($conn2,$query2);


$queryPortal = "INSERT INTO  Tbl_System_Approver_list([SYSTEM ID],[SYSTEM NAME],[APPROVER NUMBER],[FULL NAME],[EMAIL ADDRESS],SECTION,POSITION,ADID,[EMPLOYEE NUMBER]) VALUES ('30','Process Document Auto Updater - SCI','0','$fullname_new','$emailadd_new','$section_new','$position_new','$adid_new','$biph_id')";
$resultsPortal = sqlsrv_query($conn_portal,$queryPortal);


// REMOVED BY LEMY 08/13/2024
/*if ($emailadd_new !="" || $emailadd_new) {
 include '../email/newAccount.php';
}*/

  ?>
  <script>
      setTimeout(function() {
        swal({
          text: 'Registered Success!',
          title: "New Account Creation", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/accounts.php";
        });
      }, 100);
    </script>
  <?php

}

### ADD SECTION  ###

elseif ($function == "add_section") {

  $biph_id = $_GET['biph_id'];
  $new_section = $_POST['new_section'];
  $accountType = $_GET['accountType'];
  $user_fullname = $_GET['fullname'];

  $sql = "SELECT Section FROM EmployeeDetails WHERE Section = '$new_section'";
  $params = array();
  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
  $row_count = sqlsrv_num_rows( $stmt );

  if ($row_count >=1) {
    $query2 = "INSERT INTO  AdditionalSection(Section,BIPH_ID,DateAdded,PICAdded,AccountType,FullName) VALUES ('$new_section','$biph_id','$today','$fullname','$accountType','$user_fullname')";
    $results2 = sqlsrv_query($conn2,$query2);
    header('Location:../forms/update-accounts.php?biphid='.$biph_id.'&number=2');

    //Added by Lemy 02/11/25
    
  /*  $queryPortal = "INSERT INTO  Tbl_System_Approver_list([SYSTEM ID],[SYSTEM NAME],[APPROVER NUMBER],[FULL NAME],[EMAIL ADDRESS],SECTION,POSITION,ADID,[EMPLOYEE NUMBER]) VALUES ('30','Process Document Auto Updater - SCI','0','$fullname_new','$emailadd_new','$section_new','$position_new','$adid_new','$biph_id')";
    $resultsPortal = sqlsrv_query($conn_portal,$queryPortal);*/

  }
  else{
    ?>
    <script>
      setTimeout(function() {
        swal({
          text: 'Invalid Section! Please check your input and try again.',
          title: "Additional Section", 
          type: "error",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/update-accounts.php?biphid=<?php echo $biph_id;?>&number=2'";
        });
      }, 100);
    </script>
    <?php
  }
}

### CREATE NEW REQUEST  ###

elseif ($function == "create_new") {

  $sciNo_final = $_POST['sciNo'];
  $revNo_final = $_POST['revNo'];
  $title_final = $_POST['title'];
  $model_final = $_POST['model'];
  $request_section_final = $_POST['request_section'];
  $select_spv_final = $_POST['select_spv'];
  $select_mgr_final = $_POST['select_mgr'];
  $validity_final = $_POST['validity'];
  $validity_date_final = $_POST['validity_date'];
  $details_final = $_POST['details'];
  $details_final = str_replace("'","''",$details_final);

// Added by Lemy 03/04/25
  $title_final = str_replace("'","''",$title_final);

  $request_module = "New";
  $sciFinal = "TBA";
  $sciType = "NEW";

  if ($validity_final == 'Permanent') {
   $final_validity_date = 'N/A';
  }
  else{
    $final_validity_date = $validity_date_final;
  }


/*RECORD ID*/
$sql3 = "SELECT MAX(ID)+1 as lastID FROM SCI_Request";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $lastID = $row3['lastID'];
  if ($lastID == null || $lastID == "") {
    $requestID = "REQUEST-SCI-1";
  }
  else{
    $requestID = "REQUEST-SCI-".$lastID;
  }
  
}


/*SCI ATTACHMENT*/
if (!is_dir("../SCI/".$section."/Request/".$requestID."/")) {
  mkdir('../SCI/'.$section.'/Request/'.$requestID.'/', 0777, true);
}
$filePath = '../SCI/'.$section.'/Request/'.$requestID.'/';
$randNum = rand(1,100);
$file_name =$requestID.'-'.$randNum.'-'.$_FILES['file']['name'];
$file_tmp =$_FILES['file']['tmp_name'];
$file_name = str_replace( array( '\'', '"',',','#','%','&','^','$',' ',';', '<', '>' ), '_', $file_name);
move_uploaded_file($file_tmp,$filePath.$file_name);

/*INSERT TO MAIN REQUEST*/
$query1 = "INSERT INTO SCI_Request(RequestDate,RequestID,RequestType,SCINo,RevNo,Title,Model,SPV,MGR,Validity,ValidityDate,RequestDetails,Requestor,RequestSection,SCIExcel,SCIForProcess,Status,Location) VALUES ('$today','$requestID','NEW','TBA','00','$title_final','$model_final','$select_spv_final','$select_mgr_final','$validity_final','$final_validity_date','$details_final','$fullname','$section','$file_name',1,'SPV APPROVAL','SPV')";
$results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
$query2 = "INSERT INTO SCI_Approval(RequestID,Requestor,Requestor_ADID,SPV,MGR) VALUES ('$requestID','$fullname','$useradid','$select_spv_final','$select_mgr_final')";
$results2 = sqlsrv_query($conn2,$query2);


/*INSERT TO SCI LOGS*/
$querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Request for NEW SCI','$fullname')";
$resultsSCI = sqlsrv_query($conn2,$querySCI);

 /*EMAIL NOTIFICATION*/
 include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          title: 'Request for New SCI Success',
          text: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true,
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);

    </script>

 <?php

}


### CREATE REVISION REQUEST  ###

elseif ($function == "create_rev") {

  $sciNo_final = $_POST['sciNo_rev'];
  $revNo_final = $_POST['revNo_rev'];
  $request_section_final = $_POST['request_section'];
  $title_final = $_POST['title_rev'];
  $model_final = $_POST['model_rev'];
  $select_spv_final = $_POST['select_spv_rev'];
  $select_mgr_final = $_POST['select_mgr_rev'];
  $validity_final = $_POST['validity_rev'];
  $validity_date_final = $_POST['validity_date_rev'];
  $details_final = $_POST['details_rev'];
  $details_final = str_replace("'","''",$details_final);

  // Added by Lemy 03/04/25
  $title_final = str_replace("'","''",$title_final);

  $request_module = "Revision of";
  $sciFinal = $sciNo_final.'-'.$revNo_final;
  $sciType = "REVISION";

  if ($validity_rev == 'Permanent') {
   $final_validity_date = 'N/A';
  }
  else{
    $final_validity_date = $validity_date_final;
  }


/*RECORD ID*/
$sql3 = "SELECT MAX(ID)+1 as lastID FROM SCI_Request";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $lastID = $row3['lastID'];
  if ($lastID == null || $lastID == "") {
    $requestID = "REQUEST-SCI-1";
  }
  else{
    $requestID = "REQUEST-SCI-".$lastID;
  }
  
}


/*SCI ATTACHMENT*/

if (!is_dir("../SCI/".$section."/Request/".$requestID."/")) {
  mkdir('../SCI/'.$section.'/Request/'.$requestID.'/', 0777, true);
}
$filePath = '../SCI/'.$section.'/Request/'.$requestID.'/';
$randNum = rand(1,100);
$file_name =$requestID.'-'.$randNum.'-'.$_FILES['file_rev']['name'];
$file_tmp =$_FILES['file_rev']['tmp_name'];
$file_name = str_replace( array( '\'', '"',',','#','%','&','^','$',' ',';', '<', '>' ), '_', $file_name);
move_uploaded_file($file_tmp,$filePath.$file_name);


/*INSERT TO MAIN REQUEST*/
   $query1 = "INSERT INTO SCI_Request(RequestDate,RequestID,RequestType,SCINo,RevNo,Title,Model,SPV,MGR,Validity,ValidityDate,RequestDetails,Requestor,RequestSection,SCIExcel,SCIForProcess,Status,Location) VALUES ('$today','$requestID','REVISION','$sciNo_final','$revNo_final','$title_final','$model_final','$select_spv_final','$select_mgr_final','$validity_final','$final_validity_date','$details_final','$fullname','$section','$file_name',1,'SPV APPROVAL','SPV')";
    $results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
$query2 = "INSERT INTO SCI_Approval(RequestID,Requestor,Requestor_ADID,SPV,MGR) VALUES ('$requestID','$fullname','$useradid','$select_spv_final','$select_mgr_final')";
$results2 = sqlsrv_query($conn2,$query2);

    /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Request for SCI Revision [ ".$sciFinal." ]','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

 /*EMAIL NOTIFICATION*/
  include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          text: 'Request for Revision [<?php echo $sciFinal; ?>] Success!',
          title: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>

 <?php

}

### CREATE ABOLITION REQUEST  ###

elseif ($function == "create_abo") {

  $sciNo_final = $_POST['sciNo_abo'];
  $revNo_final = $_POST['revNo_abo'];
  $request_section_final = $_POST['request_section'];
  $title_final = $_POST['title_abo'];
  $model_final= $_POST['model_abo'];
  $select_spv_final = $_POST['select_spv_abo'];
  $select_mgr_final = $_POST['select_mgr_abo'];
  $validity_final = $_POST['validity_abo'];
  $validity_date_final = $_POST['validity_date_abo'];
  $details_final = $_POST['details_abo'];
  $details_final = str_replace("'","''",$details_final);

  $request_module = "Abolition of";
  $sciFinal = $sciNo_final.'-'.$revNo_final;
  $sciType = "ABOLITION";

  if ($validity_final == 'Permanent') {
   $final_validity_date= 'N/A';
  }
  else{
    $final_validity_date = $validity_date_final;
  }


/*RECORD ID*/
$sql3 = "SELECT MAX(ID)+1 as lastID FROM SCI_Request";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $lastID = $row3['lastID'];
  if ($lastID == null || $lastID == "") {
    $requestID = "REQUEST-SCI-1";
  }
  else{
    $requestID = "REQUEST-SCI-".$lastID;
  }
  
}

/*SCI ATTACHMENT*/

if (!is_dir("../SCI/".$section."/Request/".$requestID."/")) {
  mkdir('../SCI/'.$section.'/Request/'.$requestID.'/', 0777, true);
}


/*INSERT TO MAIN REQUEST*/
   $query1 = "INSERT INTO SCI_Request(RequestDate,RequestID,RequestType,SCINo,RevNo,Title,Model,SPV,MGR,Validity,ValidityDate,RequestDetails,Requestor,RequestSection,SCIExcel,SCIForProcess,Status,Location) VALUES ('$today','$requestID','ABOLITION','$sciNo_final','$revNo_final','$title_final','$model_final','$select_spv_final','$select_mgr_final','$validity_final','$final_validity_date','$details_final','$fullname','$section','N/A',0,'SPV APPROVAL','SPV')";
    $results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
$query2 = "INSERT INTO SCI_Approval(RequestID,Requestor,Requestor_ADID,SPV,MGR) VALUES ('$requestID','$fullname','$useradid','$select_spv_final','$select_mgr_final')";
$results2 = sqlsrv_query($conn2,$query2);


     /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Request for SCI Abolition [ ".$sciFinal." ]','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

    $details_final = str_replace("''","'",$details_final);

 /*EMAIL NOTIFICATION*/
  include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          text: 'Request for Abolition of [<?php echo $sciNo_final.'-'.$revNo_final; ?>] Success!',
          title: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>

 <?php

}

### RE-APPLY NEW REQUEST  ###
elseif ($function == "reapply_new") {

  $requestID = $_GET['requestID'];
 
  $sciNo_final = $_POST['sciNo'];
  $revNo_final = $_POST['revNo'];
  $title_final = $_POST['title'];
  $model_final = $_POST['model'];
  $request_section_final = $_POST['request_section'];
  $select_spv_final = $_POST['select_spv'];
  $select_mgr_final = $_POST['select_mgr'];
  $validity_final = $_POST['validity'];
  $validity_date_final = $_POST['validity_date'];
  $details_final = $_POST['details'];
  $details_final = str_replace("'","''",$details_final);

  $request_module = "Creation of New";
  $sciFinal = "TBA";
  $sciType = "NEW";

  if ($validity_final == 'Permanent') {
    $final_validity_date = 'N/A';
  }
  else{
    $final_validity_date = $validity_date_final;
  }


/*SCI ATTACHMENT*/


$filePath = '../SCI/'.$section.'/Request/'.$requestID.'/';

$files = glob($filePath.'/*');  

foreach($files as $file) { 

  if(is_file($file))  

    unlink($file);  
}


$randNum = rand(1,100);
$file_name =$requestID.'-'.$randNum.'-'.$_FILES['file']['name'];
$file_tmp =$_FILES['file']['tmp_name'];
$file_name = str_replace( array( '\'', '"',',','#','%','&','^','$',' ',';', '<', '>' ), '_', $file_name);
move_uploaded_file($file_tmp,$filePath.$file_name);


/*INSERT TO MAIN REQUEST*/
   $query1 = "UPDATE SCI_Request SET RequestDate ='$today',RequestType = 'NEW',SCINo = '$sciNo_final',RevNo='$revNo_final',Title='$title_final',Model='$model_final',SPV='$select_spv_final',MGR='$select_mgr_final',Validity='$validity_final',ValidityDate='$final_validity_date',RequestDetails='$details_final',Requestor='$fullname',RequestSection='$section',SCIExcel ='$file_name',SCIForProcess=1,Status='SPV APPROVAL',Location='SPV',Implement = 0 WHERE RequestID = '$requestID'";
    $results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
    $query2 = "UPDATE SCI_Approval SET SPV='$select_spv_final',MGR='$select_mgr_final',SPV_status=null,SPV_date=null,SPV_remarks=null,MGR_status=null,MGR_date=null,MGR_remarks=null,RejectedAt=null,AdminReject=null,AdminRejectDate=0 WHERE RequestID = '$requestID'";
    $results2 = sqlsrv_query($conn2,$query2);


    /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Re-apply for NEW SCI','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

 /*EMAIL NOTIFICATION*/
 include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          text: 'Re-applying for New SCI Success!',
          title: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>

 <?php

}

### RE-APPLY REVISION REQUEST  ###

elseif ($function == "reapply_rev") {

  $requestID = $_GET['requestID']; 

  $sciNo_final = $_POST['sciNo_rev'];
  $revNo_final = $_POST['revNo_rev'];
  $request_section_final = $_POST['request_section'];
  $title_final = $_POST['title_rev'];
  $model_final = $_POST['model_rev'];
  $select_spv_final = $_POST['select_spv_rev'];
  $select_mgr_final = $_POST['select_mgr_rev'];
  $validity_final = $_POST['validity_rev'];
  $validity_date_final = $_POST['validity_date_rev'];
  $details_final = $_POST['details_rev'];
  $details_final = str_replace("'","''",$details_final);

  $request_module = "Revision of";
  $sciFinal = $sciNo_final.'-'.$revNo_final;
  $sciType = "REVISION";

  if ($validity_final == 'Permanent') {
   $final_validity_date = 'N/A';
  }
  else{
    $final_validity_date = $validity_date_final;
  }

/*SCI ATTACHMENT*/
$filePath = '../SCI/'.$section.'/Request/'.$requestID.'/';

$files = glob($filePath.'/*');  

foreach($files as $file) { 

  if(is_file($file))  

    unlink($file);  
}


$randNum = rand(1,100);
$file_name =$requestID.'-'.$randNum.'-'.$_FILES['file_rev']['name'];
$file_tmp =$_FILES['file_rev']['tmp_name'];
$file_name = str_replace( array( '\'', '"',',','#','%','&','^','$',' ',';', '<', '>' ), '_', $file_name);
move_uploaded_file($file_tmp,$filePath.$file_name);

/*INSERT TO MAIN REQUEST*/
   $query1 = "UPDATE SCI_Request SET RequestDate ='$today',RequestType = 'REVISION',SCINo = '$sciNo_final',RevNo='$revNo_final',Title='$title_final',Model='$model_final',SPV='$select_spv_final',MGR='$select_mgr_final',Validity='$validity_final',ValidityDate='$final_validity_date',RequestDetails='$details_final',Requestor='$fullname',RequestSection='$section',SCIExcel ='$file_name',SCIForProcess=1,Status='SPV APPROVAL',Location='SPV',Implement = 0 WHERE RequestID = '$requestID'";
    $results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
    $query2 = "UPDATE SCI_Approval SET SPV='$select_spv_final',MGR='$select_mgr_final',SPV_status=null,SPV_date=null,SPV_remarks=null,MGR_status=null,MGR_date=null,MGR_remarks=null,RejectedAt=null,AdminReject=null,AdminRejectDate=0 WHERE RequestID = '$requestID'";
    $results2 = sqlsrv_query($conn2,$query2);


    /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Re-apply for REVISION SCI [ ".$sciNo_final."-".$revNo_final." ]','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

 /*EMAIL NOTIFICATION*/
 include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          text: 'Re-applying for Revision [<?php echo $sciNo_rev.'-'.$revNo_rev; ?>] Success!',
          title: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>

 <?php

}



### RE-APPLY ABOLITION REQUEST  ###

elseif ($function == "reapply_abo") {

  $requestID = $_GET['requestID'];

  $sciNo_final = $_POST['sciNo_abo'];
  $revNo_final = $_POST['revNo_abo'];
  $request_section_final = $_POST['request_section'];
  $title_final = $_POST['title_abo'];
  $model_final = $_POST['model_abo'];
  $select_spv_final = $_POST['select_spv_abo'];
  $select_mgr_final = $_POST['select_mgr_abo'];
  $validity_final = $_POST['validity_abo'];
  $validity_date_final = $_POST['validity_date_abo'];
  $details_final = $_POST['details_abo'];
  $details_final = str_replace("'","''",$details_final);

  $request_module = "Revision of";
  $sciFinal = $sciNo_final.'-'.$revNo_final;
  $sciType = "REVISION";


  if ($validity_date_final == 'Permanent') {
   $final_validity_date_abo= 'N/A';
  }
  else{
    $final_validity_date_abo = $validity_date_final;
  }



/*INSERT TO MAIN REQUEST*/
   $query1 = "UPDATE SCI_Request SET RequestDate = '$today',SCINo='$sciNo_final',RevNo='$revNo_final',Title='$title_final',Model='$model_final',SPV='$select_spv_final',MGR='$select_mgr_final',Validity='$validity_final',ValidityDate='$final_validity_date_abo',RequestDetails='$details_final',Requestor='$fullname',RequestSection='$section',Status='SPV APPROVAL',Location='SPV',Implement = 0 WHERE RequestID = '$requestID'";
    $results1 = sqlsrv_query($conn2,$query1);

/*INSERT TO APPROVAL*/
    $query2 = "UPDATE SCI_Approval SET SPV='$select_spv_final',MGR='$select_mgr_final',SPV_status=null,SPV_date=null,SPV_remarks=null,MGR_status=null,MGR_date=null,MGR_remarks=null,RejectedAt=null,AdminReject=null,AdminRejectDate=null WHERE RequestID = '$requestID'";
    $results2 = sqlsrv_query($conn2,$query2);


    /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Re-apply for SCI Abolition [ ".$sciNo_final."-".$revNo_final." ]','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

 /*EMAIL NOTIFICATION*/
 include '../email/SCIEmail_requestApproval.php';
 ?>

<script>
      setTimeout(function() {
        swal({
          text: 'Re-applying for Abolition of [ <?php echo $sciNo_final.'-'.$revNo_final; ?> ] Success!',
          title: "Request ID - <?php echo $requestID ?>", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true, 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>

 <?php

}

/*REMOVE ADDITIONAL SECTION*/

else if ($function == 'removeAdditionalSection') {

  $biph_id = $_GET['biph_id'];
  $item_id = $_GET['item_id'];

  $queryRemoveSection = "DELETE FROM AdditionalSection WHERE ID = '$item_id'";
  $resultsRemoveSection= sqlsrv_query($conn2,$queryRemoveSection);

  header('Location:../forms/update-accounts.php?biphid='.$biph_id.'&number=2');

}

/*SCI APPROVAL [SPV AND MANAGERS]*/

else if ($function == 'sciApproval') {

  $requestID = $_GET['requestID'];
  $requestType = $_GET['requestType'];

  $sqlRequest = "SELECT * FROM SCI_Request WHERE RequestID = '$requestID'";
      $stmtRequest = sqlsrv_query($conn2,$sqlRequest);
      while($rowRequest = sqlsrv_fetch_array($stmtRequest, SQLSRV_FETCH_ASSOC)) {
        $SCINo = $rowRequest['SCINo'];
        $RevNo = $rowRequest['RevNo'];
        $Title = $rowRequest['Title'];
        $Model = $rowRequest['Model'];
        $SPV = $rowRequest['SPV'];
        $MGR = $rowRequest['MGR'];
        $Validity = $rowRequest['Validity'];
        $ValidityDate = $rowRequest['ValidityDate'];
        $RequestSection = $rowRequest['RequestSection'];
        $RequestDate = $rowRequest['RequestDate'];
        $Requestor = $rowRequest['Requestor'];
        $RequestType = $rowRequest['RequestType'];
        $RequestDetails = $rowRequest['RequestDetails'];
        $sciCombine = $SCINo.'-'.$RevNo;
      }

  /* SPV APPROVAL */
  if ($accounttype == 'SUPERVISOR') {

    $query = "UPDATE SCI_Approval SET SPV = '$fullname',SPV_status='APPROVED',SPV_date='$today',SPV_remarks='-',SPV_ADID = '$useradid' WHERE RequestID = '$requestID'";
    $results = sqlsrv_query($conn2,$query);

    $query2 = "UPDATE SCI_Request SET Status = 'MGR APPROVAL',Location='MGR' WHERE RequestID = '$requestID'";
    $results2 = sqlsrv_query($conn2,$query2);

    /*INSERT TO SCI LOGS*/
    $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','SPV Approved','$fullname')";
      $resultsSCI = sqlsrv_query($conn2,$querySCI);

      /*created by: Lem 04/23/2024*/
      if ($requestType == 'NEW') {
        $sciFinalSPV = $SCINo;
      }
      else{
        $sciFinalSPV = $sciCombine;
      }

    /*INSERT EMAIL NOTIFICATION HERE*/
    include '../email/SCIEmail_spvApproval.php';

  }

  /* MGR APPROVAL */
    else {

      if ($requestType == 'NEW') {

       $sqlsci = "SELECT COUNT(ID) as totalSCICount FROM SCI_MainData WHERE Section = '$RequestSection' ";
       $stmtsci = sqlsrv_query($conn2,$sqlsci);
       while($rowsci = sqlsrv_fetch_array($stmtsci, SQLSRV_FETCH_ASSOC)) {
        $totalSCICount = $rowsci['totalSCICount'];
      }
      if ($totalSCICount > 0) {
        $sql3 = "SELECT MAX(SCINo) as lastSCI FROM SCI_MainData WHERE Section = '$RequestSection' ";
        $stmt3 = sqlsrv_query($conn2,$sql3);
        while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
          $lastSCI = $row3['lastSCI'];
        }
        $nextSCI = substr($lastSCI, -4);
        $nextSCI = ltrim($nextSCI, "0");
        $nextSCI = $nextSCI + 1;

        $lenght = strlen($nextSCI);
        if ($lenght == 1) {
          $finalSCI = "000".$nextSCI;
        }
        elseif ($lenght == 2) {
          $finalSCI = "00".$nextSCI;
        }
        elseif  ($lenght == 3) {
          $finalSCI = "0".$nextSCI;
        }
        else{
          $finalSCI = $nextSCI;
        }

        $finalSCI = "SCI".'-'.$RequestSection.'-'.$finalSCI;

      }
      else{

         $finalSCI = "SCI".'-'.$RequestSection.'-0001';

      }
      
        if (!is_dir("../SCI/".$RequestSection."/MainData/".$finalSCI."/")) {
          mkdir('../SCI/'.$RequestSection.'/MainData/'.$finalSCI.'/', 0777, true);
        }


        $queryInsert = "INSERT INTO SCI_MainData(DateModified,Section,SCINo,RevNo,Title,Model,Validity,ValidityDate,IssuanceDate,Status) VALUES ('$today','$RequestSection','$finalSCI','$RevNo','$Title','$Model','$Validity','$ValidityDate','$today_noTime','Active')";
          $resultsSCI = sqlsrv_query($conn2,$queryInsert);


        $query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
        $results = sqlsrv_query($conn2,$query);

        $query2 = "UPDATE SCI_Request SET Status = 'APPROVED',Location='-',SCINo = '$finalSCI',ForFinalSCI = 1,Implement = 1 WHERE RequestID = '$requestID'";
        $results2 = sqlsrv_query($conn2,$query2);

        /*INSERT TO SCI LOGS*/
        $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved [ ".$finalSCI." ]','$fullname')";
          $resultsSCI = sqlsrv_query($conn2,$querySCI);

          /*INSERT TO DOCUMENT LOGS*/
          $queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$finalSCI','00','NEW','$RequestDetails','$Requestor','$requestID','$SPV','$MGR','$Requestor')";
          $resultsDocs = sqlsrv_query($conn2,$queryDocs);


      }


      elseif ($requestType == 'REVISION') {

        
        $dirPath = "../forms/";

        $files = glob($dirPath . "/*");
        
       /* foreach ($files as $file) {
          echo basename($file) . "<br>";
        }*/
        

        /*MOVING OLD FILES TO ANOTHER FOLDER*/
     /*   $currentFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/";
        $newFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/Revised/".$RevNo."/";
        $files = scandir($currentFolder);*/
/*
        if (!is_dir($newFolder)) {
          mkdir($newFolder, 0777, true);
        }

        foreach($files as $fname) {
          if($fname != '.' && $fname != '..') {
            rename($currentFolder.$fname, $newFolder.$fname);
          }
        }*/

        /*CREATE REVISION NUMBER*/
        $newRev = $RevNo + 1;
        $lenght = strlen($newRev);
        if ($lenght == 1) {
          $newRev = "0".$newRev;
        }

/*
       $queryInsert = "UPDATE SCI_MainData SET DateModified = '$today', RevNo = '$newRev',Title = '$Title', Model='$Model', Validity='$Validity',ValidityDate='$ValidityDate', IssuanceDate='$today_noTime', Status='Active' WHERE SCINo='$SCINo'";
       $resultsSCI = sqlsrv_query($conn2,$queryInsert);*/


/*
       $queryInsert = "INSERT INTO SCI_ForImplement(DateApproved,Section,SCINo,RevNo,Title,Model,Validity,ValidityDate,SCIFile) VALUES ('$today','$section','$SCINo','$newRev','$Title','$Model','$Validity','$ValidityDate','-','')";
        $resultsSCIInsert = sqlsrv_query($conn2,$queryInsert);*/



       $query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
       $results = sqlsrv_query($conn2,$query);

       /*$query2 = "UPDATE SCI_Request SET SCINo='$SCINo',RevNo='$newRev',Status = 'APPROVED',Location='-',ForFinalSCI = 1 WHERE RequestID = '$requestID'";
       $results2 = sqlsrv_query($conn2,$query2);*/

       $query2 = "UPDATE SCI_Request SET SCINo='$SCINo',RevNo='$newRev',Status = 'APPROVED',Location='-' WHERE RequestID = '$requestID'";
       $results2 = sqlsrv_query($conn2,$query2);

       /*INSERT TO SCI LOGS*/
       $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved [ ".$SCINo." ]','$fullname')";
        $resultsSCI = sqlsrv_query($conn2,$querySCI);

        $finalSCI = $SCINo.'-'.$newRev;
       
      }
      /*ABOLITION*/
      else{

        $queryInsert = "UPDATE SCI_MainData SET DateModified = '$today', Status='Inactive' WHERE SCINo='$SCINo'";
        $resultsSCI = sqlsrv_query($conn2,$queryInsert);

        $query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='APPROVED',MGR_date='$today',MGR_remarks='-',MGR_ADID = '$useradid' WHERE RequestID = '$requestID'";
        $results = sqlsrv_query($conn2,$query);

        $query2 = "UPDATE SCI_Request SET Status = 'APPROVED',Location='-',Implement = 1 WHERE RequestID = '$requestID'";
        $results2 = sqlsrv_query($conn2,$query2);

        /*INSERT TO SCI LOGS*/
        $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','Manager Approved Abolition [ ".$SCINo." ]','$fullname')";
          $results3 = sqlsrv_query($conn2,$querySCI);

          $finalSCI = $SCINo.'-'.$RevNo;

          /*INSERT TO DOCUMENT LOGS*/
          $queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$SCINo','$RevNo','ABOLITION','$RequestDetails','$Requestor','$requestID','$SPV','$MGR','$Requestor')";
          $resultsDocs = sqlsrv_query($conn2,$queryDocs);

          $fileLocation = "../SCI/".$RequestSection."/MainData/".$SCINo."/";

          /*INSERT WATERMARK*/
          include 'watermark.php';

          /*MOVE TO ABOLISH FOLDER*/
    
          $currentFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/";
          $newFolder = "../SCI/".$RequestSection."/Abolished/".$SCINo."/";
          $files = scandir($fileLocation);

          if (!is_dir($newFolder)) {
            mkdir($newFolder, 0777, true);
          }

          foreach($files as $fname) {
            if($fname != '.' && $fname != '..') {
              rename($fileLocation.$fname, $newFolder.$fname);
            }
          }

          rmdir($fileLocation); 

      }

          /*INSERT EMAIL NOTIFICATION HERE*/
          include '../email/SCIEmail_mgrApproval.php';

      }
      ?>
      <script>
      setTimeout(function() {
        swal({
          text: 'Request Approval - <?php echo $requestID ?>',
          title: "Approval Success!", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/sciForApproval.php";
        });
      }, 100);
    </script>
      <?php

}

elseif ($function == 'sciDecline') {
  $requestID = $_GET['requestID'];
  $reqReason = $_POST['reqReason'];
  $reqReason = str_replace("'","''",$reqReason);

  if ($accounttype == 'SUPERVISOR') {
    $query = "UPDATE SCI_Approval SET SPV = '$fullname',SPV_status='DECLINED',SPV_date='$today',SPV_remarks='$reqReason',SPV_ADID = '$useradid',RejectedAt='SUPERVISOR' WHERE RequestID = '$requestID'";
  }
  else{
    $query = "UPDATE SCI_Approval SET MGR = '$fullname',MGR_status='DECLINED',MGR_date='$today',MGR_remarks='$reqReason',MGR_ADID = '$useradid',RejectedAt='MANAGER' WHERE RequestID = '$requestID'";
  }
  $results = sqlsrv_query($conn2,$query);


  $query2 = "UPDATE SCI_Request SET Status = 'DECLINED',Location='Requestor', Implement = 99 WHERE RequestID = '$requestID'";
  $results2 = sqlsrv_query($conn2,$query2);

  /*INSERT TO SCI LOGS*/
  $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','".$accounttype." Declined [Reason:  ".$reqReason." ]','$fullname')";
    $resultsSCI = sqlsrv_query($conn2,$querySCI);

    /*EMAIL NOTIFICATION HERE*/
    $reqReason = str_replace("''","'",$reqReason);

    include '../email/SCIEmail_spvDecline.php';
    ?>
    <script>
      setTimeout(function() {
        swal({
          text: 'Request Decline - <?php echo $requestID ?>',
          title: "Decline Success!", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/sciForApproval.php";
        });
      }, 100);
    </script>
    <?php

}


elseif ($function == 'sciImplement') {
  $requestID = $_GET['requestID'];
  $sql = "SELECT * FROM SCI_Request WHERE RequestID = '$requestID' ";
  $stmt = sqlsrv_query($conn2,$sql);
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = $row['ID'];
    $RequestID = $row['RequestID'];
    $DateModified = $row['DateModified'];
    $RequestSection = $row['RequestSection'];
    $SCINo = $row['SCINo'];
    $RevNo = $row['RevNo'];
    $Title = $row['Title'];
    $Model = $row['Model'];
    $Validity = $row['Validity'];
    $ValidityDate = $row['ValidityDate'];
    $SCIPDF = $row['SCIPDF'];
    $RequestSection = $row['RequestSection'];
    $RequestDate = $row['RequestDate'];
    $Requestor = $row['Requestor'];
    $SPV = $row['SPV'];
    $MGR = $row['MGR'];
    $RequestDetails = $row['RequestDetails'];

    $SCINo_final = $SCINo.'-'.$RevNo;
  }

  /* REVISION NUMBER FOLDER*/
  $revFolder = $RevNo - 1;
  $lenghtFolder = strlen($revFolder);
  if ($lenghtFolder == 1) {
    $revFolder = "0".$revFolder;
  }

      /*MOVING OLD FILES TO ANOTHER FOLDER*/
        $currentFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/";
        $newFolder = "../SCI/".$RequestSection."/MainData/".$SCINo."/Revised/".$revFolder."/";
        $files = scandir($currentFolder);

        if (!is_dir($newFolder)) {
          mkdir($newFolder, 0777, true);
        }

        foreach($files as $fname) {
          if($fname != '.' && $fname != '..') {
            rename($currentFolder.$fname, $newFolder.$fname);
          }
        }

        $queryInsert = "UPDATE SCI_MainData SET DateModified = '$today', RevNo = '$RevNo',Title = '$Title', Model='$Model', Validity='$Validity',ValidityDate='$ValidityDate', IssuanceDate='$today_noTime', Status='Active' WHERE SCINo='$SCINo'";
        $resultsSCI = sqlsrv_query($conn2,$queryInsert);

        $query2 = "UPDATE SCI_Request SET ForFinalSCI = 1, Implement = 1 WHERE RequestID = '$requestID'";
        $results2 = sqlsrv_query($conn2,$query2);


        /*INSERT TO SCI LOGS*/
        $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','SCI Implemented','$fullname')";
          $resultsSCI = sqlsrv_query($conn2,$querySCI);

        /*INSERT TO DOCUMENT LOGS*/
        $queryDocs = "INSERT INTO SCI_DocumentLogs(TransactedDate,SCINo,RevNo,DocType,RequestDetails,Requestor,RequestID,SPV,MGR,ImplementedBy) VALUES ('$today','$SCINo','$RevNo','REVISION','$RequestDetails','$Requestor','$requestID','$SPV','$MGR','$fullname')";
        $resultsDocs = sqlsrv_query($conn2,$queryDocs);



          ?>
          <script>
            setTimeout(function() {
              swal({
                text: 'SCI <?php echo $SCINo_final ?> Implemented Success.',
                title: "SCI Implementation", 
                type: "success",   
                showConfirmButton: true,
                confirmButtonText: "OK",   
                closeOnConfirm: true 
              }, function(){
                window.location = "../forms/sciImplement.php";
              });
            }, 100);
          </script>
          <?php

}


### CANCEL REQUEST  ###

elseif ($function == "cancelRequest") {

  $requestID = $_GET['requestID'];
  $cancelReason = $_POST['cancelReason'];
  $cancelReason = str_replace("'","''",$cancelReason);

  $cancelEvent = "Cancellation of Request [Reason: ".$cancelReason."]";
  /*INSERT TO REQUEST LOGS*/
  $querySCI = "INSERT INTO SCI_RequestLogs(TransactionDate,RequestID,Event,AccountName) VALUES ('$today','$requestID','$cancelEvent','$fullname')";
  $resultsSCI = sqlsrv_query($conn2,$querySCI);
  
    /*INSERT TO CANCEL LOGS*/
  $queryCancel= "INSERT INTO SCI_Cancel(CancelDate,CancelReason,RequestID,Requestor) VALUES ('$today','$cancelReason','$requestID','$fullname')";
  $resultsCancel = sqlsrv_query($conn2,$queryCancel);

 $query = "UPDATE SCI_Request SET Status = 'CANCELLED', SCIForProcess=0, ForFinalSCI=0 WHERE RequestID = '".$requestID."'";
 $results = sqlsrv_query($conn2,$query);

  ?>
  <script>
      setTimeout(function() {
        swal({
          text: 'Cancellation of Request <?php echo $requestID?> success.',
          title: "Cancel Request", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/ongoingRequest.php";
        });
      }, 100);
    </script>
  <?php

}



### UPLOAD MAIN DATA  ###

elseif ($function == "uploadData") {

  $select_section = $_POST['select_section'];
  $uploadCode = date("Ymdhi");

  /*INSERT TO REQUEST LOGS*/
  $querySCI = "INSERT INTO SCI_UploadDataLogs(DateUpload,UploadCode,Section,UploadAdmin,UploadStatus,CancelDate,CancelAdmin) VALUES ('$today','$uploadCode','$select_section','$fullname','Active','-','-')";
  $resultsSCI = sqlsrv_query($conn2,$querySCI);


  $fileName = $_FILES["excelFile"]["name"];
  $fileExtension = explode('.', $fileName);
  $fileExtension = strtolower(end($fileExtension));
  $newFileName = $select_section." - ".date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

  $targetDirectory = "../SCI/Uploads/" . $newFileName;
  move_uploaded_file($_FILES['excelFile']['tmp_name'], $targetDirectory);

  /*error_reporting(0);
  ini_set('display_errors', 0);*/


  require_once '../excelReader/excel_reader2.php';
  require_once '../excelReader/SpreadsheetReader.php';

   $reader = new SpreadsheetReader($targetDirectory);
  foreach($reader as $key => $row){
    $dateMod = $row[0];
    $section = $row[1];
    $scino = $row[2];
    $revno = $row[3];
    $title = $row[4];
    $model = $row[5];
    $validity = $row[6];
    $validity_date = $row[7];
    $issuance = $row[8];
    $sci_file = $row[9];

    $querySCIUpload = "INSERT INTO SCI_MainData(DateModified,Section,SCINo,RevNo,Title,Model,Validity,ValidityDate,IssuanceDate,SCIFile,Status,UploadCode) VALUES ('$dateMod','$section','$scino','$revno','$title','$model','$validity', '$validity_date','$issuance','$sci_file','Active','$uploadCode')";
    $resultsSCIUpload = sqlsrv_query($conn2,$querySCIUpload);
  }

   $querySCIDelete = "DELETE FROM SCI_MainData WHERE DateModified = 'DateModified'";
    $resultsSCIDelete = sqlsrv_query($conn2,$querySCIDelete);
 

  ?>
  <script>
      setTimeout(function() {
        swal({
          text: 'Upload Data Success',
          title: "Upload Main Data", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/sciUploadDataLogs.php";
        });
      }, 100);
    </script>
  <?php

}


elseif ($function == "moveFolder") {
  $sql = "SELECT sci_number FROM SCI_Temp ORDER BY id ASC";
  $params = array();
  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
  $row_count = sqlsrv_num_rows( $stmt );

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $SCINo[] = $row['sci_number'];
  }

  foreach ($SCINo as $new_scino) {

    $fromItem = "../SCI/IC/MainData/Data/$new_scino.pdf";
    $destination = "../SCI/IC/MainData/$new_scino/$new_scino.pdf";
    rename($fromItem, $destination);

  }

}

elseif ($function == 'employeeSync' ) {

  $sql = "SELECT BIPH_ID,AccountType,UserADID FROM Accounts WHERE SystemNo = 2 AND AccountStatus = 'Active' ";
  $params = array();
  $option =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt = sqlsrv_query( $conn2, $sql , $params, $option );
  $row_count = sqlsrv_num_rows( $stmt );

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $biph_id = $row['BIPH_ID'];
    $account_type = $row['AccountType'];
    $adid = $row['UserADID'];

    $sql2 = "SELECT Section,Department,Status,Position FROM EmployeeDetails WHERE EmpNo = '$biph_id' ";
    $params2 = array();
    $option2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt2 = sqlsrv_query( $conn2, $sql2 , $params2, $option2 );
    $row_count2 = sqlsrv_num_rows( $stmt2 );

    if ($row_count2 >=1) {
      # Active sa EMS
      while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        $Section = $row2['Section'];
        $Department = $row2['Department'];
        $Status = $row2['Status'];
        $Position = $row2['Position'];
      }

      $staffEng = array("Junior Staff","Staff","Senior Staff","Engineer","Senior Engineer","Leader","Assistant Leader");
      $spv = array("Junior Supervisor","Supervisor","Senior Supervisor","Specialist","Junior Specialist","Senior Specialist");
      $mgr = array("Assistant Manager","Manager","Senior Manager","Deputy General Manager","General Manager","Factory Manager");

      if(in_array($Position, $staffEng, true)) {
        $position_final = 'STAFF/ENGINEER';
      }
      else if(in_array($Position, $spv, true)) {
        $position_final = 'SUPERVISOR';
      }
      else if(in_array($Position, $mgr, true)) {
        $position_final = 'MANAGER';
      }
      else{
        $position_final = "COMMON";
      }

      if ($Status == 'ACTIVE') {
        $status_final = 'Active';
      }
      else{
        $status_final = 'Inactive';
      }
      if ($account_type = 'ADMIN') {
        $position_final = 'ADMIN';
      }

      $query = "UPDATE Accounts SET Department = '$Department', Section='$Section', AccountType='$position_final',AccountStatus='$status_final'
       WHERE BIPH_ID = '$biph_id' ";
      $results = sqlsrv_query($conn2,$query);

    }
    else{

      if ($adid == 'common') {
        # no update
      }
      else{
        $query = "UPDATE Accounts SET AccountStatus='Inactive' WHERE BIPH_ID = '$biph_id' ";
        $results = sqlsrv_query($conn2,$query);

      }
    }
  }
?>
  <script>
      setTimeout(function() {
        swal({
          text: 'Process Success',
          title: "Employee Sync", 
          type: "success",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
          window.location = "../forms/accounts.php";
        });
      }, 100);
    </script>
  <?php

}


### BATCH APPROVAL - Added By Lemy - 05/27/25

elseif ($function == 'batch_approve') {

  $selected = $_POST['selected'];

  foreach ($selected as $requestID) {

      $sqlRequest = "SELECT * FROM SCI_Request WHERE RequestID = '$requestID'";
      $stmtRequest = sqlsrv_query($conn2,$sqlRequest);
      while($rowRequest = sqlsrv_fetch_array($stmtRequest, SQLSRV_FETCH_ASSOC)) {
        $SCINo = $rowRequest['SCINo'];
        $RevNo = $rowRequest['RevNo'];
        $Title = $rowRequest['Title'];
        $Model = $rowRequest['Model'];
        $SPV = $rowRequest['SPV'];
        $MGR = $rowRequest['MGR'];
        $Validity = $rowRequest['Validity'];
        $ValidityDate = $rowRequest['ValidityDate'];
        $RequestSection = $rowRequest['RequestSection'];
        $RequestDate = $rowRequest['RequestDate'];
        $Requestor = $rowRequest['Requestor'];
        $RequestType = $rowRequest['RequestType'];
        $RequestDetails = $rowRequest['RequestDetails'];
        $sciCombine = $SCINo.'-'.$RevNo;
      }

      # NEW
      if ($RequestType == 'NEW') {
        include 'batch_new.php';
      }

      # REVISION
      elseif ($RequestType == 'REVISION') {
        include 'batch_revision.php';
      }

      # ABOLITION
      else{
        include 'batch_abolition.php';
      }

      include '../email/SCIEmail_mgrApproval.php';
}
?>
<script>
  setTimeout(function() {
    swal({
      text: 'Request Approval',
      title: "Approval Success!", 
      type: "success",   
      showConfirmButton: true,
      confirmButtonText: "OK",   
      closeOnConfirm: true 
    }, function(){
      window.location = "../forms/sciForApproval.php";
    });
  }, 100);
</script>
<?php
}
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Process Document Auto Updater</title>
    <link rel="icon" href="../assets/img/update.png" type="image/gif" sizes="16x16">
</head>
<body style="background-image: url('../assets/img/bg.jpg');background-repeat: no-repeat; background-repeat: no-repeat;background-size: cover;">

</body>
</html>