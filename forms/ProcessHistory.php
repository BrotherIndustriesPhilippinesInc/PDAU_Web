<?php
include '../global/conn.php';
session_start();
$title = 'processHistory';
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
      <h1>Approval History</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body overflow-auto">

           <table class="table datatable" style="font-size:14px;">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">RequestID</th>
                    <th scope="col">WorkI</th>
                    <th scope="col">Element</th>
                    <th scope="col">No.</th>
                    <th scope="col">CycleTime</th>
                    <th scope="col">Type</th>
                    <th scope="col">Requestor</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql2 = "SELECT * FROM ProcessAttachment WHERE SPV = '$fullname' OR MNG = '$fullname' ";
                $stmt2 = sqlsrv_query($conn2,$sql2);
                while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                  $reqAttachment = $row2['RequestID'];
                  $attachment = $row2['WindowAttach'];
                  $details = $row2['Details'];
                  $efficiency = $row2['EFTeam'];
                  $efficiencyDate = $row2['EFDate'];
                  $Staff = $row2['Staff'];
                  $StaffDate = $row2['StaffDate'];
                  $SPV = $row2['SPV'];
                  $SPVDate = $row2['SPVDate'];
                  $MNG = $row2['MNG'];
                  $MNGDate = $row2['MNGDate'];

                $sql = "SELECT * FROM ProcessCheck WHERE RequestID = '$reqAttachment'";
                $stmt = sqlsrv_query($conn2,$sql);
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
                  $requestDate = date('M d, Y', strtotime($requestDate));
                      echo '
                      <tr>
                      <td>'.$requestDate.'</td>
                      <td>'.$reqAttachment.'</td>
                      <td>'.$worki.'</td>
                      <td>'.$elementname.'</td>
                      <td>'.$elementno.'</td>
                      <td>'.$cycletime.'</td>
                      <td>'.$type.'</td>
                      <td>'.$requestor.'</td>
                      <td>
                      ';

                    ?>
                    <a href="#" class="btn btn-warning btn-sm openModal" data-bs-toggle="modal" data-id="<?php echo $reqAttachment;?>" data-bs-target="#updateCustomer">View</a>
                    <?php

                  }
                }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>


        </div>
      </div>

    </div>
  </div>
</section>

 <section>
      <div class="modal fade" id="updateCustomer" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                   <div class="updateCustomer1"></div>
                    
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
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({url:"modal/historyModal.php?id="+id,cache:false,success:function(result){
          $(".updateCustomer1").html(result);
      }});
  });
</script>
</body>
</html>