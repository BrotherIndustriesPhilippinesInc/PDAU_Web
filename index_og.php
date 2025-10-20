<?php
session_start();
unset($_SESSION["pdau_id"]);
$title = "login";
include 'global/conn.php';

 /* $sql4 = "SELECT * FROM ProcessAttachment WHERE RequestID = 'REQ-20' AND Status = 'OPEN'";
        $stmt4 = sqlsrv_query($conn2,$sql4);
        while($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
          $WindowAttach = $row4['WindowAttach'];
        }
        $WorkINo = "TS-0303";

$WorkIAttachment = '\\apbiphbpswb01:8080\pdaus\attachment\20230314621-imageTest.png';

$WorkIAttachment = str_replace(':8080\pdaus','',$WorkIAttachment);
$source = '\\'.$WorkIAttachment;
$ext  = (new SplFileInfo($WorkIAttachment))->getExtension(); 
$destination = '\\\apbiphsh04\B1_BIPHCommon\16_Printer\PDAU\AttachmentFolder\MasterData\New'.''.'\\'.''.$WorkINo.'.'.$ext;

echo
$source;
*/


$reqID = $_GET['reqID'];
$control = $_GET['control'];

if ($reqID == null || $control == null) {
  header('Location:index.php?reqID=0&control=login');
}
$username = $_GET['username'];
if ($username == null) {
  header('Location:index.php?reqID=0&control=login&username=0');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Login - Process Document Auto Updater</title>


  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="assets/img/update.png" type="image/gif" sizes="16x16">
  

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<!-- <style>
aside, header,body {
  background-image: url('assets/img/cars.gif');
  background-repeat: no-repeat;
  background-attachment: fixed; 
  background-size: 100% 100%;
}
</style> -->
</head>
<!-- <style>
body {
  background-image: url('assets/img/cars.gif');
  background-repeat: no-repeat;
  background-attachment: fixed; 
  background-size: 100% 100%;
}
</style> -->


<style>


.callout {
  position: fixed;
  bottom: 35px;
  right: 20px;
  margin-left: 20px;
  max-width: 300px;
}

.callout-header {
  padding: 25px 15px;
  background: #555;
  font-size: 30px;
  color: white;
}

.callout-container {
  padding: 15px;
  background-color: #ccc;
  color: black
}

.closebtn {
  position: absolute;
  top: 5px;
  right: 15px;
  color: white;
  font-size: 30px;
  cursor: pointer;
}

.closebtn:hover {
  color: lightgrey;


}

</style>

<!-- <body style="background-image: url('assets/img/halloween.gif');background-position: center;background-repeat: no-repeat;background-size: cover;"> -->
<body>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                  <img src="assets/img/pdaus.png" alt="" height="90%;" width="90%;">
              </div><!-- End Logo -->
              <div class="card mb-3">

                <div class="card-body" style="width:  500px;">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your EmployeeID & Password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate method="POST" action="process/mainProcess.php?function=login&reqID=<?php echo $reqID ?>&control=<?php echo $control ?>">

                    <div class="col-12">
                      <label for="biph_id" class="form-label">Employee ID</label>
                      <div class="input-group has-validation">
                        <?php
                        if ($username == 0) {
                         ?>
                         <input type="search" list="brow1" class="form-control" id="biph_id" name="biph_id" placeholder="Select your Employee ID" required autocomplete="off" autofocus style="text-transform: uppercase;" onchange="sendtoPassword();">
                         <?php
                        }
                        else{
                          ?>
                          <input type="search" list="brow1" class="form-control" id="biph_id" name="biph_id" placeholder="Select your Employee ID" required autocomplete="off" value="<?php echo $username ?>" style="text-transform: uppercase;" onchange="sendtoPassword();">
                          <?php
                        }
                        ?>
                       
                       <datalist id="brow1">
                         <?php
                         $sql = "SELECT DISTINCT BIPH_ID, FullName FROM Accounts WHERE AccountStatus = 'Active' AND WebAccess = 1 ORDER BY BIPH_ID ASC ";
                         $stmt = sqlsrv_query($conn2,$sql);
                         while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                          echo '<option value="'.$row['BIPH_ID'].'">'.$row['FullName'].'</option>';
                        }
                        ?>
                      </datalist> 
                      <div class="invalid-feedback">Please Select your BIPH-ID</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="mypassword" class="form-label">Password</label>
                    <?php
                    if ($username==0) {
                     ?>
                     <input type="password" name="mypassword" class="form-control" id="mypassword" required >
                     <?php
                   }
                   else{
                    ?>
                    <input type="password" name="mypassword" class="form-control" id="mypassword" required autofocus>
                    <?php
                  }
                  ?>
                  <div class="invalid-feedback">Please enter your password!</div>
                </div>


                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" onclick="myFunction()">
                    <label class="form-check-label" for="rememberMe">Show Password</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
                <div class="col-12">
                 <a href="forgot-password.php" class="btn btn-danger w-100">Forgot Password</a>
               </div>
                   <!--  <div class="col-12">
                      <p class="small mb-0"> <i class="bx bxl-microsoft"></i> Windows Application Version Download here
                       <a href="WindowsInstaller\Setup.msi">&nbsp;&nbsp; <img src="assets/img/download.png" width="40px;" height="40px;"></a>
                     </p>
                   </div> -->
                 </form>

                </div>
              </div>

              <div class="copyright">
                &copy; 2022 <strong><span>Process Document Auto Updater</span></strong>
              </div>
              <div class="credits">
                Version <?php echo $sysVersion; ?>
              </div>
              
            </div>
          </div>
        </div>
<!--         <br>
<div class="col-12" style="font-size:15px; text-align: center;  ">
              <a href="#" onclick="alert('Manual is ongoing. Sorry for the inconvenience')"><img src="assets/img/manual.png" width="40px;" title="Click this to open System Manual"></a>&nbsp;&nbsp;&nbsp;
              <a href="#" onclick="alert('Trouble Checksheet is ongoing. Sorry for the inconvenience')"><img src="assets/img/document.png" width="40px;" title="Click here to open Trouble Checksheet"></a>&nbsp;&nbsp;&nbsp;
              <a href="#"onclick="alert('Help is on the way. Sorry for the inconvenience')"><img src="assets/img/help.png" width="40px;" title="Click here to open Help"></a>&nbsp;&nbsp;&nbsp;
              <a href="mailto:lemuel.delmundo@brother-biph.com.ph" title="Click here to email the Developer"><img src="assets/img/coding.png" width="40px;"></a>
              <a href="email/AutomaticEmail.php"> DIGITAL AUDIT </a> -->
              </div> 
              <?php
              $random = (rand(0,1));
              ?>
              <?php if ($random == 1): ?>
                 <div class="callout">
                <div class="callout-header">Hi there!<img src="assets/img/wave.gif" height="70" width="70"></div>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">×</span>
                <div class="callout-container">
                  <p>For your better viewing experience, click the <img src="assets/img/3dots.png" style="height: 20px;"> on the upper part of the screen and change your <b>Zoom</b> to 90%. <img src="assets/img/zoom.png" style="height: 40px;width: 270px;"></p>
                </div>
              </div>
              <?php endif ?>
      </section>
    </div>
     
  </main><!-- End #main -->


  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap library -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>

<button hidden id="btnLoading" onclick="setTimeout(function() {
  swal({
    title: 'Processing...', 
    text: 'Please wait while processing the data', 
    imageUrl: 'assets/img/pdau_loading.gif',    
    showConfirmButton: false,
    confirmButtonText: 'Ok',   
    closeOnConfirm: true 
}, function(){
    window.Close();
});
}, 100);">TEST</button>

  <script type="text/javascript">
    function myFunction() {
      var x = document.getElementById("mypassword");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>

  <script type="text/javascript">
  function sendtoPassword (){
   /* alert("Hello World!");*/
    document.getElementById("mypassword").focus();
  }
</script>

</body>

</html>