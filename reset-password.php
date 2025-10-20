<?php
session_start();
session_destroy();
$title = "resetPassword";
include 'global/conn.php';


if (!$_GET) {
 $biph_id = "";
}
else{
  $biph_id = $_GET['biph_id'];
}

$sql_reset = "SELECT * FROM Accounts WHERE BIPH_ID = '$biph_id' AND ChangePassMode = 'YES' ";
$params_reset = array();
$options_reset =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt_reset = sqlsrv_query( $conn2, $sql_reset , $params_reset, $options_reset );
$row_reset = sqlsrv_num_rows( $stmt_reset );



if ($row_reset <=0) {

?>
<script type="text/javascript">
/* setTimeout(function() {
  swal({
    text: 'Link expired. Process cannot proceed. For support, please contact your admin or BPS. Thank you',
    title: "Process Failed", 
    type: "error",   
    showConfirmButton: true,
    confirmButtonText: "OK",   
    closeOnConfirm: true 
  }, function(){
    window.location = "index.php";
  });
}, 1);*/
 alert('Link expired. Process cannot proceed. For support, please contact your admin or BPS. Thank you');
 window.location.replace('index.php');
</script>
<?php
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
                    <h5 class="card-title text-center pb-0 fs-4">Change Password</h5>
                    <p class="text-center small">Enter your new Password</p>
                  </div>

                  <form class="row g-3 needs-validation" id="form_submit" novalidate method="POST" action="process/mainProcess.php?function=changePassword&biph_id=<?php echo $biph_id; ?>">
                    <div class="col-12">
                      <label for="valid_email" class="form-label">New Password</label>
                      <div class="input-group has-validation">
                        <input type="password" name="new_password" class="form-control" id="new_password" required autofocus>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="valid_email" class="form-label">Re-type Password</label>
                      <div class="input-group has-validation">
                        <input type="password" name="re_password" class="form-control" id="re_password" required>
                        <div class="invalid-feedback">Please input your email</div>
                      </div>
                    </div>
                    <div class="col-12" style="text-align:center;">
                      <button class="btn btn-success w-100" type="button" onclick="confirm_submit()">Change Password</button>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-danger w-100" type="button" onclick="confirm_cancel()">Cancel</button>
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
        <br>
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
    var new_password = $('#new_password').val();
    var re_password = $('#re_password').val();
    var exist_pass = $('#exist_pass').val();

    if (new_password == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "New password", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#new_password').focus();
    }
    else if (re_password == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Retype- password", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#re_password').focus();
    }

    else if (re_password != new_password)
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Retype- password", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#re_password').focus();
      document.getElementById('re_password').value = "";
    }

     else{
        
      setTimeout(function() {
        swal({
          title: 'Change Password',
          text: 'Are you sure you want to Change your password?',
          imageUrl: 'assets/img/warning.png',
          showCancelButton: true,
          confirmButtonColor: 'green',
          confirmButtonText: 'Yes, change it!',
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

  function confirm_cancel() {

    setTimeout(function() {
      swal({
        title: 'Cancel Update Password',
        text: 'Are you sure you want to cancel your Change Password?',
        imageUrl: 'assets/img/warning.png',
        showCancelButton: true,
        confirmButtonColor: 'red',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Cancel',
        cancelButtonColor: 'red',
        closeOnConfirm: false,
        closeOnCancel: true
      },
      function(isConfirm){
        if (isConfirm) {
         window.location.replace('index.php');
        } else {

        }
      });
    }, 100);

  }


</script>


</body>

</html>