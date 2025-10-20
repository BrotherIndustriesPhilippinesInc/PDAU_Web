<?php
include '../global/conn.php';
session_start();
$title = 'requestHistory';
$page = 'requestSPV';
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
                    <th scope="col">Model</th>
                    <th scope="col">Process</th>
                    <th scope="col">No.</th>
                    <th scope="col">Series</th>
                    <th scope="col">Type</th>
                    <th scope="col">Category</th>
                    <th scope="col">Requestor</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                  $sql = "SELECT * FROM RequestUpdate WHERE Status = 'CLOSED' AND SPVProcess = '$fullname' ORDER BY ID DESC ";
                  $stmt = sqlsrv_query($conn2,$sql);
                  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $id = $row['ID'];
                    $reqID = $row['RequestID'];
                    $status = $row['Status'];
                    $model = $row['Model'];
                    $process = $row['Process'];
                    $processno = $row['ProcessNo'];
                    $series = $row['SeriesNo'];
                    $targetdate = $row['TargetDate'];
                    $impdate = $row['ImpDate'];
                    $typetransfer = $row['TypeTransfer'];
                    $safety = $row['ProductSafety'];
                    $category = $row['Categories'];
                    $requestor = $row['Requestor'];
                    $requestDate = $row['RequestDate'];
                    $SPV = $row['SPVSelect'];
                    $requestDate = date('M d, Y', strtotime($requestDate));
                      echo '
                      <tr>
                      <td>'.$requestDate.'</td>
                      <td>'.$reqID.'</td>
                      <td>'.$model.'</td>
                      <td>'.$process.'</td>
                      <td>'.$processno.'</td>
                      <td>'.$series.'</td>
                      <td>'.$typetransfer.'</td>
                      <td>'.$category.'</td>
                      <td>'.$requestor.'</td>
                      <td>
                      ';

                    ?>
                    <a href="#" class="btn btn-warning btn-sm openModal" data-bs-toggle="modal" data-id="<?php echo $reqID;?>" data-bs-target="#updateCustomer">View</a>
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

  $('table tbody').on('click', '.openModal', function() {
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/historyModal.php?id="+id,cache:false,success:function(result){
          $(".updateCustomer1").html(result);
    }});
  });

</script>
</body>
</html>