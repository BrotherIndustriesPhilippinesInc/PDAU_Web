<?php
session_start();
$title = 'myProfile';
$user_login = $_SESSION['pdau_id'];
include '../global/userInfo.php';
/*include 'session_timer.php';*/
if ($user_login==null) {
  header("location:global/logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../global/head.php'; ?>

<body>

  <!-- ======= Header ======= -->
  <?php include '../global/header.php'; ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include '../global/sidebar.php'; ?>
  <!-- End Sidebar-->

   <?php include_once '../global/session_validator.php';?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>My Profile</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="../assets/img/user.png" alt="Profile" class="rounded-circle">
              <h2><?php echo $fullname;?></h2>
              <h3><?php echo $accounttype;?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>
               <!--  <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li> -->
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-additional-section">Additional Section</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $fullname;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">User Type</div>
                    <div class="col-lg-9 col-md-8"><?php echo $accounttype;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Register Date</div>
                    <div class="col-lg-9 col-md-8"><?php echo $registerDate;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Register By</div>
                    <div class="col-lg-9 col-md-8"><?php echo $registerPIC;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Department</div>
                    <div class="col-lg-9 col-md-8"><?php echo $department ;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Section</div>
                    <div class="col-lg-9 col-md-8"><?php echo $section;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>

                    <div class="col-lg-9 col-md-8"><a href="mailto:<?php echo $emailaddress;?>"><?php echo $emailaddress ;?></a></div>
                  </div>

                </div>


                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="POST" action="../process/mainProcess.php?function=myPassword&userID=<?php echo $_SESSION['user_id']?>">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="oldPass" type="password" class="form-control" id="oldPass" onchange="verify_pass()" required>
                        <input name="exist_pass" type="text" class="form-control" id="exist_pass" value="<?php echo $systemPass;?>" hidden >
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" required onchange="check_exist()">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewPassword" type="password" class="form-control" id="renewPassword" required onchange="check_equal()">
                      </div>
                    </div>
                    <?php if ($accounttype != 'COMMON'): ?>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                        <button name="clearBtn" id="clearBtn" type="button" class="btn btn-danger" onclick="clearFunction()">Clear Fields</button>
                      </div>
                    <?php endif ?>
                  </form><!-- End Change Password Form -->

                </div>



                <div class="tab-pane fade pt-3" id="profile-additional-section">

                  <div class="text-center">
                    <?php
                    if ($accounttype != 'SUPERVISOR' && $accounttype != 'MANAGER' && $accounttype!= 'ADMIN') {
                      ?>
                      <label style="color:red"><i><b>*** Additional section not available for this user ***</b></i></label>
                      <?php
                    }
                    ?>

                  </div>
                  <br>
                  <div class="row mb-3">
                    <div class="col-md-8 col-lg-12">
                      <table class="table table-bordered" style="font-size:14px;">
                        <thead>
                          <tr>
                            <th scope="col">Section</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Admin</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          $sql = "SELECT * FROM AdditionalSection WHERE BIPH_ID = '$BIPH_ID' ORDER BY Section ASC ";
                          $stmt = sqlsrv_query($conn2,$sql);
                          while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $id = $row['ID'];
                            $Section = $row['Section'];
                            $dateAdd = $row['DateAdded'];
                            $picAdd = $row['PICAdded'];

                            echo '
                            <tr>
                            <td>'.$Section.'</td>
                            <td>'.$dateAdd.'</td>
                            <td>'.$picAdd.'</td>
                            ';
                          }
                          ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>





            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->


<!-- ======= Footer ======= -->
<?php include '../global/footer.php'; ?>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include '../global/scripts.php'; ?>

<script>
  function verify_pass() {
    var oldPass= document.getElementById('oldPass');
    var exist_pass = document.getElementById('exist_pass');
    if (oldPass.value != exist_pass.value)
    {
      alert("Please input your current password!");
      oldPass.value="";
      oldPass.focus();
      return false;
    }
  }
</script>
<script>
  function check_exist() {
    var newPassword= document.getElementById('newPassword');
    var exist_pass = document.getElementById('exist_pass');
    if (newPassword.value == exist_pass.value)
    {
      alert("Password already exist. Please try new password");
      newPassword.value="";
      newPassword.focus();
      return false;
    }
  }
</script>

<script>
  function check_equal() {
    var newPassword= document.getElementById('newPassword');
    var renewPassword = document.getElementById('renewPassword');
    if (newPassword.value != renewPassword.value)
    {
      alert("Password not match!");
      renewPassword.value="";
      renewPassword.focus();
      return false;
    }
  }
</script>

<script>
  function clearFunction() {
    var oldPass= document.getElementById('oldPass');
    var newpassword= document.getElementById('newPassword');
    var renewPassword= document.getElementById('renewPassword');
    oldPass.value="";
    newpassword.value="";
    renewPassword.value="";
    oldPass.focus();
  }
</script>
</body>

</html>