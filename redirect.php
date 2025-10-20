<?php
session_start();
session_destroy();
$title = "login";
include 'global/conn.php';
if (!$_GET) {
 $username = "";
}
else{
  $username = $_GET['username'];
  $password = $_GET['password'];
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




<body onload="loadFunction()">

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

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your EmployeeID & Password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate method="POST" action="process/mainProcess.php?function=login" id="formRedirect">

                    <div class="col-12">
                      <label for="biph_id" class="form-label">Employee ID</label>
                      <div class="input-group has-validation">
                        <input type="text" name="biph_id" class="form-control" id="biph_id" required  oninput="this.value = this.value.toUpperCase()" value="<?php echo $username;?>">
                        <div class="invalid-feedback">Please enter your BIPH-ID</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="mypassword" class="form-label">Password</label>
                      <input type="password" name="mypassword" class="form-control" id="mypassword" required value="<?php echo $password;?>">
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" onclick="myFunction()">
                        <label class="form-check-label" for="rememberMe">Show Password</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="button" name="submit_redirect" id="submit_redirect">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Forgot account? <a href="#">Click here to retrive your account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Developed by <a href="#">B.P.S 2022</a>
              </div>

            </div>
          </div>
        </div>

      </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script type="text/javascript">
    function myFunction() {
      var x = document.getElementById("mypassword");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    function loadFunction() {
      document.getElementById('formRedirect').submit();
    }
  </script>

</body>

</html>