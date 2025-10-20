<?php
session_start();
$title = 'dashboard';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';
$date_filter = $_GET['date'];
$date_convert = date('F d, Y', strtotime($date_filter));

if ($date_filter == "" || $date_filter == null) {
  header("Location:dashboard.php?date=$today_formated");
}

include '../global/userInfo.php';
include '../process/dashboard_details.php';

?>
<!DOCTYPE html>
<html lang="en">

<style type="text/css">
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 20%;
  }
</style>
<?php include '../global/head.php'; ?>

<body>

 <?php include '../global/header.php'; ?>

  <?php include '../global/sidebar.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard - <?php echo $date_convert; ?>
         <button type="button" id="filter" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomer" style="float: right;">Filter Date</button>
      </h1>
    </div><!-- End Page Title -->
   
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
             <!--  <img src="assets/img/underConstruction.png" alt="Profile"  width="1200" height="600"> -->
              <br>
             <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Request For Update   <span> - Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <?php
                      if ($accounttype == "SUPERVISOR") {
                       echo '<a href="RequestForApproval.php"><i class="bi bi-arrow-clockwise"></i></a>';
                      }else{
                        echo '<i class="bi bi-arrow-clockwise"></i>';
                      }
                      ?>
                    </div>
                    <div class="ps-3">
                      <p>Supervisor's Approval:</p>
                        <p></p>
                        <span style="font-size: 24px;"><?php echo $request_pending;?> Request</span>
                        <p></p>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Process Checking <span> - Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="ProcessChecking.php" style="color:green;"><i class="bi bi-filetype-pdf"></i></a>
                    </div>
                    <div class="ps-3">
                      <p>Supervisor:&nbsp;&nbsp;&nbsp;<span style="font-size: 20px;color:green"><?php echo $process_pending;?> Request</span></p>
                      <p>Manager:&nbsp;&nbsp;&nbsp;<span style="font-size: 20px;color:orange"><?php echo $process_pending;?> Request</span></p>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-xl-6">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Activity Checklist Target</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                   <i class="bi bi-list-check"></i>
                    </div>
                    <div class="ps-3">
                      <h5 style="color: blue;"><b>Target :  <?php echo $Target; ?></b></h6>
                      <h5 style="color: green;"><b>Actual:  <?php echo $Actual; ?></b></h6>
                      <h5 style="color: red;"><b>Percentage:  <?php echo $percentage; ?> %</b></h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

             <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Important Items Audit</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <a href="DailyAudit.php?date=<?php echo $date_filter;?>" target="_blank"><i class="bi bi-clipboard-check"></i></a>
                    </div>
                    <div class="ps-3">
                      <h5 style="color: green;"><b>Jigs -  <?php echo $jig_audit; ?></b></h6>
                      <h5 style="color: orange;"><b>Grease -  <?php echo $grease_audit; ?></b></h6>
                      <h5 style="color: maroon;"><b>Torque -  <?php echo $torque_audit; ?></b></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
          <h5 class="card-title">Activity Checklist</span></h5>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">ActivityID</th>
                        <th scope="col">Operator</th>
                        <th scope="col">Section</th>
                        <th scope="col">Line</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Examiner</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                $sql = "SELECT * FROM Activity_MainData WHERE ActivityDate = '$date_filter' ORDER BY ID";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $ActivityID = $row['ActivityID'];
                  $BIPHID = $row['BIPHID'];
                  $FullName = $row['FullName'];
                  $Department = $row['Department'];
                  $Section = $row['Section'];
                  $Line = $row['Line'];
                  $Model = $row['Model'];
                  $Process = $row['Process'];
                  $ProcessNo = $row['ProcessNo'];
                  $Purpose = $row['Purpose'];
                  $ActivityDate = $row['ActivityDate'];
                  $Examiner = $row['Examiner'];
                  $Status = $row['Status'];
                  $FullName = utf8_encode($FullName);
                    echo '
                    <tr>
                    <td>'.$ActivityDate.'</td>
                    <td>'.$ActivityID.'</td>
                    <td>'.$FullName.'</td>
                    <td>'.$Section.'</td>
                    <td>'.$Line.'</td>
                    <td>'.$Purpose.'</td>
                    <td>'.$Examiner.'</td>
                   ';
                   if ($Status == "DONE") {
                     echo '<td style="color:green"><strong>'.$Status.'</strong></td>';
                   }
                   elseif ($Status == "ONGOING") {
                     echo '<td style="color:blue"><strong>'.$Status.'</strong></td>';
                   }
                   elseif ($Status == "CANCELLED") {
                     echo '<td style="color:orange"><strong>'.$Status.'</strong></td>';
                   }
                   elseif (($Status == "FAILED")) {
                      echo '<td style="color:red"><strong>'.$Status.'</strong></td>';
                   }
                   echo '<td>';
                   ?>
                   <a href="ActivityDetails.php?auditID=<?php echo $ActivityID;?>&status=<?php echo $Status; ?>" title="More details">
                     <i class="bi bi-three-dots"></i>
                   </a>
                 </td>
                </tr>
                   <?php
                    }
                 ?>
                  
                    </tbody>

                  </table>


                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
      </div>
    </section>

    <section>
<div class="modal fade" id="addCustomer" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Date</h5>
      </div>
      <div class="modal-body">
        <form action="dashboard.php?year=year_select">
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Select Date:</label>
            <div class="col-sm-9">
              <input type="date" name="date" id="date" class="form-control" required value="<?php echo $date_filter;?>">
            </div>
          </div>
          <br>
          <div class="text-center">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>

  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>
</body>

</html>