<?php
session_start();
unset($_SESSION["pdau_id"]);
$title = "login";
include 'global/conn.php';



$reqID = $_GET['reqID'];
$control = $_GET['control'];

if ($reqID == null || $control == null) {
  header('Location:index.php?reqID=0&control=login');
}
$username = $_GET['username'];
if ($username == null) {
  header('Location:index.php?reqID=0&control=login&username=0');
}



$sql = "SELECT TOP(1) USERNAME FROM Tbl_lOGIN_Request WHERE HOSTNAME = '$ip_client' AND STATUS = 'ACTIVE' ORDER BY ID DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn_portal, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );

 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $username_login = $row['USERNAME'];
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

              <?php
              if ($row_count <= 0) {
                ?>
                <div class="card" style="font-family: segoe ui; width:  500px;">
                  <div class="card-header" style="background: #009">
                    <span style="color:#FFDF00">Can't Proceed to Login!</span>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title" ></h5>
                    <p class="card-text" style="color: #000080;font-weight: 600">Sorry, no login request found in I-Portal!</p>
                    <p class="card-text" style="color: #000080;font-weight: 600">With this, kindly login to I-Portal first</p>
                    <p class="card-text" style="color: #000080;font-weight: 600">If the I-Portal application is not yet installed to your computer,</p>
                    <p class="card-text" style="color: #000080;font-weight: 600">click the button below to install.</p>
                    <p class="card-text" style="color: #000080;font-weight: 600">( Click <span style="color:green;font-weight: 700">RE-LOGIN</span> after your login to I-Portal )</p>
                    <br>
                    <a target="_blank" href="http://apbiphbpswb01:8080/approval-system/Views/iportal-dashboard.php" class="btn btn-primary">Open / Install I-Portal System</a>
                  </div>
                  <div class="card-footer">
                    <span style="float: right; font-size: 12px;font-style: italic;color:black">If you have any concern, you may call BPS-Application group local no. 3407</span>
                  </div>
                </div>
                <?php
              }
              ?>

        


              <div class="card mb-3">
                <div class="card-body" style="width:  500px;">
                  <form class="row g-3 needs-validation" novalidate method="POST" action="process/mainProcess.php?function=login&reqID=<?php echo $reqID ?>&control=<?php echo $control ?>">

                    <div class="row g-4">
                     <div class="col-6">
                      <a href="global/requestController.php?<?php echo "reqID=$reqID&control=$control" ?>" class="btn btn-success w-100" type="button" style="font-weight: 700">RE-LOGIN</a>
                     </div>
                     <div class="col-6">
                        <a href="process/mainProcess.php?function=visitor" class="btn btn-primary w-100" type="button" style="font-weight: 700">LOGIN AS VISITOR</a>
                     </div>
                   </div>
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