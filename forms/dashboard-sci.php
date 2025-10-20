<?php
session_start();
$title = 'dashboard';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');
$page="";

include '../global/conn.php';
$date_filter = $_GET['date'];
$date_convert = date('F d, Y', strtotime($date_filter));

if ($date_filter == "" || $date_filter == null) {
  header("Location:dashboard-sci.php?date=$today_formated");
}




/*$newstring = substr("SCI-BPS-9999", -4);

$str = ltrim($newstring, "0");
$test2 = $str + 1;

$lenght = strlen($test2);
if ($lenght == 1) {
  $final = "000".$test2;
}
elseif ($lenght == 2) {
  $final = "00".$test2;
}
elseif  ($lenght == 3) {
  $final = "0".$test2;
}
else{
  $final = $test2;
}
$section9 = "BPS";

$final = "SCI".'-'.$section9.'-'.$final;*/

include '../global/userInfo.php';
include '../process/dashboard_sci_details.php';

include_once '../global/session_validator.php';

/*CREATE DIRECTORY*/
/*if (!is_dir("../SCI/".$section."/MainData/")) {
  mkdir('../SCI/'.$section.'/MainData/', 0777, true);
}
if (!is_dir("../SCI/".$section."/Request/")) {
  mkdir('../SCI/'.$section.'/Request/', 0777, true);
}
*/


// $dirPath contain path to directory whose files are to be listed 


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
      <h1>Dashboard
         <button hidden type="button" id="filter" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#filterDate" style="float: right;">Filter Date</button>
      </h1>
    </div><!-- End Page Title -->

   
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

             <!--  <img src="assets/img/underConstruction.png" alt="Profile"  width="1200" height="600"> -->
              <br>
             <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- ONGOING -->
           
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Ongoing Request">
              <div class="card info-card sales-card">
                 <a type="button" data-bs-toggle="modal" data-bs-target="#ongoing" name="btnOngoing">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">Ongoing</h5>
                  <span class="badge bg-primary rounded-pill text-light prevent-select" style="font-size:40px;"><?php echo $totalOngoing; ?></span>
                </div>
                </a>
              </div>
            </div>
           
             <!-- SPV Approval -->
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Ongoing Supervisor's Approval">
              <div class="card info-card sales-card">
                <a type="button" data-bs-toggle="modal" data-bs-target="#spv_approval" name="btnSPV">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">SPV Approval</h5>
                  <span class="badge bg-info rounded-pill text-light" style="font-size:40px;"><?php echo $totalSpvApproval; ?></span>
                </div>
              </a>
              </div>
            </div>
             <!-- MGR Approval -->
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Ongoing Manager's Approval">
              <div class="card info-card sales-card">
                 <a type="button" data-bs-toggle="modal" data-bs-target="#mgr_approval" name="btnMGR">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">MGR Approval</h5>
                  <span class="badge bg-secondary rounded-pill text-light" style="font-size:40px;"><?php echo $totalMgrApproval; ?></span>
                </div>
              </a>
              </div>
            </div>
             <!-- Approved -->
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Approved Request">
              <div class="card info-card sales-card">
                 <a type="button" data-bs-toggle="modal" data-bs-target="#approved" name="btnApproved">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">Approved</h5>
                  <span class="badge bg-success rounded-pill text-light" style="font-size:40px;"><?php echo $totalApproved; ?></span>
                </div>
              </a>
              </div>
            </div>
            <!-- Cancelled -->
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Cancelled Request">
              <div class="card info-card sales-card">
                <a type="button" data-bs-toggle="modal" data-bs-target="#cancelled" name="btnCancelled">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">Cancelled</h5>
                  <span class="badge bg-warning rounded-pill text-light" style="font-size:40px;"><?php echo $totalCancelled; ?></span>
                </div>
              </a>
              </div>
            </div>
             <!-- Abolished -->
            <div class="col-xxl-2 col-md-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View Abolished SCI Documents">
              <div class="card info-card sales-card">
                <a type="button" data-bs-toggle="modal" data-bs-target="#abolished" name="btnAbolished">
                <div class="card-body" style="text-align: center;">
                  <h5 class="card-title" style="font-size: 18px;">Abolished</h5>
                  <span class="badge bg-danger rounded-pill text-light" style="font-size:40px;"><?php echo $totalAboished; ?></span>
                </div>
                </a>
              </div>
            </div>
             

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card overflow-auto">
                <div class="card-body">
          <h5 class="card-title">SCI Request</span></h5>
                  <table name="tblRequest" class="table table-hover" id="example1" style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col" style="font-size:15px;" hidden>ID</th>
                        <th scope="col" style="font-size:15px;">Date</th>
                        <th scope="col" style="font-size:15px;">RequestID</th>
                        <th scope="col" style="font-size:15px;">Section</th>
                        <th scope="col" style="font-size:15px;">Type</th>
                        <th scope="col" style="font-size:15px;">SCI No</th>
                        <th scope="col" style="font-size:15px;">Title</th>
                        <th scope="col" style="font-size:15px;">Model</th>
                        <th scope="col" style="font-size:15px;">Requestor</th>
                        <th scope="col" style="font-size:15px;">Status</th>
                        <th scope="col"></th>
                      </tr>
                      <tr>
                        <th scope="col" hidden></th>
                        <th scope="col"></th>
                        <th scope="col">RequestID</th>
                        <th scope="col">Section</th>
                        <th scope="col">Type</th>
                        <th scope="col">SCI No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Model</th>
                        <th scope="col">Requestor</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($section == 'Common') {
                        
                        $sql = "SELECT * FROM SCI_Request WHERE Status != 'FINISHED' or Status != 'CANCELLED' ORDER BY ID DESC";
                      }
                      else{
                        //$sql = "SELECT * FROM SCI_Request WHERE RequestSection = '$section' AND (Status != 'FINISHED' or Status != 'CANCELLED') ORDER BY ID DESC";
                        //var_dump($user_login);

                        $sql = "SELECT * 
                                  FROM SCI_Request
                                  WHERE (RequestSection = '$section'
                                        OR RequestSection IN (SELECT Section 
                                                              FROM AdditionalSection 
                                                              WHERE BIPH_ID = '$user_login'))
                                    AND Status != 'FINISHED'
                                    AND Status != 'CANCELLED'
                                  ORDER BY ID DESC;";
                      }
                      
                      $stmt = sqlsrv_query($conn2,$sql);

                      while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $id = $row['ID'];
                        $RequestDate = $row['RequestDate'];
                        $RequestID = $row['RequestID'];
                        $RequestType = $row['RequestType'];
                        $SCINo = $row['SCINo'];
                        $RevNo = $row['RevNo'];
                        $Title = $row['Title'];
                        $Model = $row['Model'];
                        $SPV = $row['SPV'];
                        $MGR = $row['MGR'];
                        $Validity = $row['Validity'];
                        $ValidityDate = $row['ValidityDate'];
                        $RequestDetails =$row['RequestDetails'];
                        $Requestor = $row['Requestor'];
                        $RequestSection = $row['RequestSection'];
                        $SCIExcel = $row['SCIExcel'];
                        $SCIPDF = $row['SCIPDF'];
                        $SCIForProcess = $row['SCIForProcess'];
                        $Status = $row['Status'];
                        $Location = $row['Location'];
                        $RequestDetails = mb_convert_encoding($RequestDetails, 'UTF-8', array('EUC-JP', 'SHIFT-JIS', 'AUTO'));

                        if ($RequestType == 'NEW') {
                          $SCINo_final = $SCINo;
                        }
                        else{
                          $SCINo_final = $SCINo.'-'.$RevNo;
                        }
                        echo '
                        <tr>
                        <td hidden>'.$id.'</td>
                        <td>'.$RequestDate.'</td>
                        <td>'.$RequestID.'</td>
                        <td>'.$RequestSection.'</td>
                        ';
                        if ($RequestType == 'NEW') {
                          echo ' <td class="text-success"><b>'.$RequestType.'</b></td>';
                        }
                        elseif ($RequestType == 'REVISION') {
                         echo ' <td class="text-primary"><b>'.$RequestType.'</b></td>';
                        }
                        else{
                          echo ' <td class="text-warning"><b>'.$RequestType.'</b></td>';
                        }
                        echo'
                        <td>'.$SCINo_final.'</td>
                        <td>'.$Title.'</td>
                        <td>'.$Model.'</td>
                        <td>'.$Requestor.'</td>
                        ';
                        if ($Status == 'SPV APPROVAL' || $Status == 'MGR APPROVAL') {
                          echo '<td>
                          <a class="btn btn-sm btn-primary openApprovalStatus" title="'.$Status.'" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewApprovalStatus"><b>'.$Status.'</b></a>
                          </td>
                          ';
                        }
                        elseif ($Status == 'DECLINED') {
                          echo '<td> <a class="btn btn-sm btn-danger openRejected" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewRejected"><b>'.$Status.'</b></a>';                   
                        }
                        elseif ($Status == 'APPROVED') {
                          echo '<td>
                          <a class="btn btn-sm btn-success openApprovalStatus" title="'.$Status.'" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewApprovalStatus"><b>'.$Status.'</b></a>
                          </td>';
                        }
                         elseif ($Status == 'CANCELLED') {
                          echo '<td>
                          <a class="btn btn-sm btn-warning openCancelled" title="'.$Status.'" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewCancelled"><b>'.$Status.'</b></a>
                          </td>';

                        }
                        echo '
                        <td> <a class="openSCILogs" id="launchModal" href="#" data-id="'.$id.'" data-toggle="modal" data-target="#viewSCILogs"><img src="../assets/img/log.png" width="25px;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Request Logs"></a></td>
                        ';
                          echo'
                        ';

                        ?>

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
      <div class="modal fade" id="filterDate" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Filter Date</h5>
            </div>
            <div class="modal-body">
              <form action="dashboard-sci.php?year=year_select">
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

     <section>
      <div class="modal fade" id="viewSCILogs" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="displaySCILogs"></div>
         </div>
       </div>
     </div>
   </section>

    <section>
      <div class="modal fade" id="viewApprovalStatus" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="displayApprovalStatus"></div>
         </div>
       </div>
     </div>
    </section>


   <section>
    <div class="modal fade" id="viewRejected" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="displayRejected"></div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="modal fade" id="viewCancelled" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="displayCancelled"></div>
        </div>
      </div>
    </div>
  </section>

    <?php
    include '../modal/dashboard_ongoing.php';
    include '../modal/dashboard_spvApproval.php';
    include '../modal/dashboard_mgrApproval.php';
    include '../modal/dashboard_approved.php';
    include '../modal/dashboard_abolished.php';
    include '../modal/dashboard_cancelled.php';




    ?>




  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>



 <script type="text/javascript">

  $(document).ready( function () {

      new DataTable('#example1', {
        responsive: true,
        autoWidth: false, 
        initComplete: function () {
          this.api()
          .columns([1,2,3,4,5,6,7,8,9])
          .every(function () {
            let column = this;
            let title = column.header().textContent;

                // Create input element
                let input = document.createElement('input');
                input.style.cssText = 'width:90px;font-size:14px;';
                input.type = 'text';
                input.placeholder = title;
                column.header().replaceChildren(input);

                // Event listener for user input
                input.addEventListener('keyup', () => {
                  if (column.search() !== this.value) {
                    column.search(input.value).draw();
                  }
                });
              });
        },
        order: [[0, 'DESC']],
        columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7,8,9] }
        ]
      });

  } );
</script>


</body>

</html>