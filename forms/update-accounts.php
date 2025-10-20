<?php
session_start();
$title = 'accounts';

$biphid = $_GET['biphid'];
$number = $_GET['number'];

$user_login = $_SESSION['pdau_id'];
include '../global/userInfo.php';
/*include 'session_timer.php';*/
if ($user_login==null) {
  header("location:global/logout.php");
}
if ($biphid == null || $number == null) {
  header("location:accounts.php");
}

include 'conn.php';
$sql = "SELECT * FROM Accounts WHERE BIPH_ID =  '".$biphid."' ";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $id = $row['ID'];
  $useradid_update = $row['UserADID'];
  $fullname_update = $row['FullName'];
  $department_update = $row['Department'];
  $section_update = $row['Section'];
  $emailaddress_update = $row['EmailAddress'];
  $accounttype_update = $row['AccountType'];
  $accountstatus_update = $row['AccountStatus'];
  $registerPIC_update = $row['RegisterPIC'];
  $systemPass_update = $row['SystemPassword'];
  $registerDate_update = $row['RegisterDate'];
  $systemNo_update = $row['SystemNo'];
  $accountCode_update = $row['AccountCode'];
  /*$registerDate = date('F d, Y', strtotime($registerDate));*/
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

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Update Accounts</h1>
    </div><!-- End Page Title -->

     <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="../assets/img/user.png" alt="Profile" class="rounded-circle">
              <h2><?php echo $fullname_update;?></h2>
              <h3><?php echo $accounttype_update;?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <?php

                if ($number == 1) {
                 ?>
                 <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile_additional_section">Additional Section</button>
                </li>

                 <?php
                }
                else{
                  ?>
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>
                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile_additional_section">Additional Section</button>
                  </li>
                  <?php
                }

                ?>

              </ul>
              <div class="tab-content pt-2">
                <?php
                if ($number == 1) {
                  ?>
                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <?php
                }
                else{
                  ?>
                   <div class="tab-pane fade profile-overview" id="profile-overview">
                  <?php
                }
                ?>
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">BIPH-ID</div>
                    <div class="col-lg-9 col-md-8"><?php echo $biphid;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $fullname_update;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">User Type</div>
                    <div class="col-lg-9 col-md-8"><?php echo $accounttype_update;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Register Date</div>
                    <div class="col-lg-9 col-md-8"><?php echo $registerDate_update;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Register By</div>
                    <div class="col-lg-9 col-md-8"><?php echo $registerPIC_update;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Department</div>
                    <div class="col-lg-9 col-md-8"><?php echo $department_update ;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Section</div>
                    <div class="col-lg-9 col-md-8"><?php echo $section_update;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>

                    <div class="col-lg-9 col-md-8"><a href="mailto:<?php echo $emailaddress_update;?>"><?php echo $emailaddress_update ;?></a></div>
                  </div>

                </div>

               
               <?php
               if ($number == 1) {
                ?>
                <div class="tab-pane fade pt-3" id="profile_additional_section">
                <?php
               }
               else{
                ?>
                <div class="tab-pane fade show active pt-3" id="profile_additional_section">
                <?php
               }
               ?>
                  <!-- Change Password Form -->
                  <form method="POST" id="sectionForm" name="sectionForm" action="../process/mainProcess.php?function=add_section&biph_id=<?php echo $biphid;?>&accountType=<?php echo $accounttype_update;?>&fullname=<?php echo $fullname_update; ?>">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Select Section</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="search" list="brow1" class="form-control" id="new_section" name="new_section" placeholder="Select Section" autocomplete="off" onchange="checkID();"> 
                       <datalist id="brow1">
                         <?php
                         $sql = "SELECT DISTINCT Section FROM EmployeeDetails WHERE Section is not null AND Section!='$section_update' AND Section not in (SELECT Section collate SQL_Latin1_General_CP1_CI_AS  FROM AdditionalSection WHERE BIPH_ID collate SQL_Latin1_General_CP1_CI_AS  = '$biphid' ) ORDER BY Section";
                         $stmt = sqlsrv_query($conn2,$sql);
                         while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                          echo '<option>'.$row['Section'].'</option>';
                        }
                        ?>
                      </datalist> 
                      </div>
                    </div>

                    <div class="text-center">
                      <?php
                      if ($accounttype_update != 'SUPERVISOR' && $accounttype_update != 'MANAGER' && $accounttype_update != 'STAFF/ENGINEER') {
                        ?>
                        <label style="color:red"><i><b>*** Additional Section is not available for this account ***</b></i></label>
                        <?php
                      }
                      else{
                        ?>
                        <?php if ($accountCode == 1): ?>
                             <button type="button" name="add_section" id="add_section" class="btn btn-success">Add Section</button>
                        <?php endif ?>
                      
                        <?php
                      }

                      ?>
                     
                    </div>
                  </form><!-- End Change Password Form -->
                  <br>
                   <div class="row mb-3">
                      <div class="col-md-8 col-lg-12">
                       <table class="table table-bordered" style="font-size:14px;" name="tblAdditionalSection">
              <thead>
                <tr>
                  <th scope="col">Section</th>
                  <th scope="col">Date Added</th>
                  <th scope="col">Admin</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
              
              
                $sql = "SELECT * FROM AdditionalSection WHERE BIPH_ID = '$biphid' ORDER BY Section ASC ";
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
                  <td>
                  ';

                    ?>
                    <?php if ($accountCode==1): ?>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to Remove <?php echo $Section ?> section?')" style="display: block;margin: auto;" href="../process/mainProcess.php?function=removeAdditionalSection&item_id=<?php echo $id; ?>&biph_id=<?php echo $biphid ?>" name="btnRemove">
                       <i class="bi bi-trash"></i> Remove
                      </a>
                    <?php endif ?>
                    
                    <?php
                  }
                ?>
              </td>
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
  $(document).ready(function(){
    $('#add_section').click(function(){
      var new_section = $('#new_section').val();
      var biph_id = $('#biph_id').val();
    
      if (new_section == "")
      {
        alert("All  fields are required!");
        $('#new_section').focus();
      }
      else
      {

        setTimeout(function() {
          swal({
            title: 'Add Section',
            text: 'Are you sure you want to add Section ?',
            imageUrl: '../assets/img/question-red.png',
            showCancelButton: true,
            confirmButtonColor: 'green',
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel',
            cancelButtonColor: 'red',
            closeOnConfirm: false,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
           document.getElementById('sectionForm').submit();

            } else {

            }
          });
        }, 100);

      }
    });
  });
</script>




</body>

</html>