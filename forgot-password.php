<?php
session_start();
session_destroy();
$title = "forgotPassword";
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
if (!$_GET) {
 $username = "";
}
else{
  $username = $_GET['username'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Forgot Password - Process Document Auto Updater</title>


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

                <div class="card-body" style="width:500px;">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Forgot Password</h5>
                    <p class="text-center small">Enter your valid Email Address</p>
                  </div>

          <form class="row g-3 needs-validation" id="form_submit" novalidate method="POST" action="process/mainProcess.php?function=forgotPassword">
                      <div class="col-12">
                        <label for="valid_email" class="form-label">Email Address</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="valid_email" class="form-control" id="valid_email" required autofocus>
                        <input type="text" name="domain_name" class="form-control" id="domain_name" readonly value="@brother-biph.com.ph">
                        <div class="invalid-feedback">Please input your email</div>
                      </div>
                      </div>
                    <div class="col-12">
                      <button class="btn btn-danger w-100" type="button" onclick="confirm_submit()">Reset Password</button>
                    </div>
                     <div class="col-12">
                      <a href="index.php" class="btn btn-primary w-100">Login</a>
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
                Version 1.0.0
              </div>
              
            </div>
          </div>
        </div>
        <br>
<!-- <div class="col-12" style="font-size:15px; text-align: center;  ">
              <a href="#" onclick="alert('Manual is ongoing. Sorry for the inconvenience')"><img src="assets/img/manual.png" width="40px;" title="Click this to open System Manual"></a>&nbsp;&nbsp;&nbsp;
              <a href="#" onclick="alert('Trouble Checksheet is ongoing. Sorry for the inconvenience')"><img src="assets/img/document.png" width="40px;" title="Click here to open Trouble Checksheet"></a>&nbsp;&nbsp;&nbsp;
              <a href="#"onclick="alert('Help is on the way. Sorry for the inconvenience')"><img src="assets/img/help.png" width="40px;" title="Click here to open Help"></a>&nbsp;&nbsp;&nbsp;
              <a href="mailto:lemuel.delmundo@brother-biph.com.ph" title="Click here to email the Developer"><img src="assets/img/coding.png" width="40px;"></a> -->
            <!--   <a href="email/AutomaticEmail.php"> DIGITAL AUDIT </a> -->
              </div>
      </section>
    </div>
     
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
  function confirm_submit() {
    var valid_email = $('#valid_email').val();

    if (valid_email == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Valid Email", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#valid_email').focus();
    }

     else{
        
      setTimeout(function() {
        swal({
          title: 'RESET PASSWORD',
          text: 'Are you sure you want to Reset your password?',
          imageUrl: 'assets/img/warning.png',
          showCancelButton: true,
          confirmButtonColor: 'red',
          confirmButtonText: 'Yes, reset it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.getElementById("btnLoading").click();
            document.getElementById("form_submit").submit();
          } else {
             
          }
        });
      }, 100);
    }
  }
</script>


</body>

</html>