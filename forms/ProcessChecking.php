<?php
include '../global/conn.php';
session_start();
$title = 'processCheck';
$page = 'processChecking';
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
      <h1>Process Checking Approval</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body overflow-auto" style="min-height:400px;">
              <br>
              <table class="table datatable" style="font-size:14px;">
                <thead>
                  <tr>
                    <?php if ($accounttype == "SUPERVISOR"): ?>
                      <th scope="col">SPV</th>
                    <?php endif ?>
                    <?php if ($accounttype == "MANAGER"): ?>
                      <th scope="col">MNG</th>
                    <?php endif ?>
                    <th scope="col">Date</th>
                    <th scope="col">RequestID</th>
                    <th scope="col">WorkI</th>
                    <th scope="col">Element</th>
                    <th scope="col">No.</th>
                    <th scope="col">CT</th>
                    <th scope="col">Type</th>
                    <th scope="col">Requestor</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                  if ($accounttype == "SUPERVISOR") {
                    $sql = "SELECT * FROM ProcessCheck WHERE Status = 'OPEN' AND Location = 'SPV' ORDER BY ID DESC ";
                    $stmt = sqlsrv_query($conn2,$sql);
                  }
                  else{
                    $sql = "SELECT * FROM ProcessCheck WHERE Status = 'OPEN' AND Location = 'MNG' ORDER BY ID DESC ";
                    $stmt = sqlsrv_query($conn2,$sql);
                  }
                  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $id = $row['ID'];
                    $requestID = $row['RequestID'];
                    $status = $row['Status'];
                    $worki = $row['WorkINo'];
                    $elementno = $row['ElementNo'];
                    $elementname = $row['ElementName'];
                    $cycletime = $row['CycleTime'];
                    $efteam = $row['EFTeam'];
                    $type = $row['RequestType'];
                    $staff = $row['Staff'];
                    $SPV = $row['SPV'];
                    $MNG = $row['MNG'];
                    $requestor = $row['Requestor'];
                    $requestDate = $row['DateRequested'];
                    /*$requestDate = date('M d, Y', strtotime($requestDate));*/

//Attachment
                    $sql2 = "SELECT * FROM ProcessAttachment WHERE RequestID = '".$requestID."' AND Status = 'OPEN'";
                    $stmt2 = sqlsrv_query($conn2,$sql2);
                    while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                      $attachment = $row2['WindowAttach'];

                      $attachment = str_replace("\\", "/", $attachment);
                      $attachment = substr($attachment, 35);
                      if ($accounttype == "SUPERVISOR") {
                        if ($SPV == $fullname) {
                          echo '
                          <tr>
                          <td style=color:red><strong>'.$SPV.'</strong></td>
                          <td>'.$requestDate.'</td>
                          <td>'.$requestID.'</td>
                          <td>'.$worki.'</td>
                          <td>'.$elementname.'</td>
                          <td>'.$elementno.'</td>
                          <td>'.$cycletime.'</td>
                          <td>'.$type.'</td>
                          <td>'.$requestor.'</td>
                          <td>
                          ';
                        }
                        else{
                          echo '
                          <tr>
                          <td>'.$SPV.'</td>
                          <td>'.$requestDate.'</td>
                          <td>'.$requestID.'</td>
                          <td>'.$worki.'</td>
                          <td>'.$elementname.'</td>
                          <td>'.$elementno.'</td>
                          <td>'.$cycletime.'</td>
                          <td>'.$type.'</td>
                          <td>'.$requestor.'</td>
                          <td>
                          ';
                        }
                      }
                      else{
                        if ($MNG == $fullname) {
                          echo '
                          <tr>
                          <td style=color:red><strong>'.$MNG.'</strong></td>
                          <td>'.$requestDate.'</td>
                          <td>'.$requestID.'</td>
                          <td>'.$worki.'</td>
                          <td>'.$elementname.'</td>
                          <td>'.$elementno.'</td>
                          <td>'.$cycletime.'</td>
                          <td>'.$type.'</td>
                          <td>'.$requestor.'</td>
                          <td>
                          ';
                        }
                        else{
                          echo '
                          <tr>
                          <td>'.$MNG.'</td>
                          <td>'.$requestDate.'</td>
                          <td>'.$requestID.'</td>
                          <td>'.$worki.'</td>
                          <td>'.$elementname.'</td>
                          <td>'.$elementno.'</td>
                          <td>'.$cycletime.'</td>
                          <td>'.$type.'</td>
                          <td>'.$requestor.'</td>
                          <td>
                          ';
                        }
                      }
                      ?>
                      <div class="dropdown" >
                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li>
                            <a href="ProcessDetails.php?reqID=<?php echo $requestID;?>" class="dropdown-item" style="color:blue;"><strong>View Details</strong></a>
                          </li>
                          <li>

                            <a href="#" onclick="
                      setTimeout(function() {
                       swal({
                        title: 'Process Checking Approval',
                        text: 'Are you sure you want to approve request <?php echo $requestID;?> ?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        confirmButtonText: 'Yes, approve it!',
                        cancelButtonColor: '#',
                        cancelButtonText: 'Cancel',
                        closeOnConfirm: false,
                        closeOnCancel: true
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location = 'process/mainProcess.php?function=processApprove&id=<?php echo $requestID;?>&user=<?php echo $accounttype;?>';
                        } else {

                        }
                      });
                    }, 100);"
                    class="dropdown-item" style="color:green;"><strong>Approve</strong></a>
                          </li>
                          <li><a href="#" class="dropdown-item openModal" data-bs-toggle="modal" data-id="<?php echo $requestID;?>" data-bs-target="#declineRequest" style="color:red;"><strong>Decline</strong></a>
                          </li>
                        </ul>
                      </div>
                      <?php
                    }
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>

<!--   <?php  
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
$ip = $_SERVER['REMOTE_ADDR'];
}
echo 'User IP Address - '.$ip;   
?>   -->

</div>
</div>

</div>
</div>
</section>

<section>
  <div class="modal fade" id="declineRequest" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="declineRequest1"></div>

     </div>
   </div>
 </div>
</section>


</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include '../global/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include '../global/scripts.php'; ?>

<script>
  $('table tbody').on('click', '.openModal', function() {
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/ProcessDecline.php?id="+id,cache:false,success:function(result){
      $(".declineRequest1").html(result);
    }});
  });

</script>
</body>

</html>