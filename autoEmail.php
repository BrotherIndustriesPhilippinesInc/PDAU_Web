<?php
session_start();
session_destroy();
$title = "auto-email";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'global/head.php'; ?>
<!-- <style>
body {
  background-image: url('assets/img/cars.gif');
  background-repeat: no-repeat;
  background-attachment: fixed; 
  background-size: 100% 100%;
}
</style> -->
<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-2">
                  
                  <a href="index" style="text-align: center;"><img src="assets/img/pdaus.png" alt="" height="90%;" width="90%;"></a>
              </div><!-- End Logo -->
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 style="text-align:center; color:#012970; font-size:34px;font-family: sans-serif; "><b> Auto Email System</b> </h5>
                    <br>
                    <p class="badge bg-primary badge-number" style="text-align:center; font-size:50px; width:100%;" id="notif">loading...</p>
                  </div>
                  <br>
                    <div class="col-12">
                      <p class="small mb-0" style="color:red;text-align:center; font-size:18px;">- <i>Email Notification will be send everyday at 11:00:00 AM GMT+8</i> -</p>
                    </div>

                </div>
              </div>

              <div class="copyright">
                &copy; 2022 <strong><span>Process Document Auto Updater</span></strong>
              </div>
              <div class="credits">
                Version 1.0.0
              </div>
              <br>
            </div>
          </div>
        </div>
<div class="col-12" style="font-size:15px; text-align: center;  ">
              <a href="#"><i class="bi bi-file-pdf"></i> Manual</a>&nbsp;&nbsp;&nbsp;
              <a href="#"><i class="bi bi-card-checklist"></i> Trouble Checksheet</a>&nbsp;&nbsp;&nbsp;
              <a href="#"><i class="bi bi-question-circle"></i> Help</a>&nbsp;&nbsp;&nbsp;
              <a href="mailto:lemuel.delmundo@brother-biph.com.ph"><i class="bi bi-code-slash"></i> Developer</a>
              </div>
      </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include 'global/scripts.php'; ?>


  <script type="text/javascript">
    var timeout = setInterval(notif, 1000);    
    function notif () {
       $('#notif').load('global/checkTime.php');
   }
</script>

</body>

</html>