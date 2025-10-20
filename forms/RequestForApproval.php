<?php
include '../global/conn.php';
session_start();
$title = 'requestupdate';
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
      <h1>Request For Approval</h1>
    </div>
    <section>
      <!-- Recent Sales -->
      <div class="col-12">
        <div class="card recent-sales overflow-auto">
          <div class="card-body" style="min-height:400px;">
            <h5 class="card-title"></h5>
            <table class="table datatable" style="font-size:14px;">
              <thead>
                <tr>
                  <th scope="col">SPV</th>
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
              
                $sql = "SELECT * FROM RequestUpdate WHERE Status = 'OPEN' AND Location = 'SPV' ORDER BY ID ASC ";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $requestID = $row['RequestID'];
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
               
                    if ($SPV == $fullname) {
                      echo '
                      <tr>
                      <td style=color:red><strong>'.$SPV.'</strong></td>
                      <td>'.$requestDate.'</td>
                      <td>'.$requestID.'</td>
                      <td>'.$model.'</td>
                      <td>'.$process.'</td>
                      <td>'.$processno.'</td>
                      <td>'.$series.'</td>
                      <td>'.$typetransfer.'</td>
                      <td>'.$category.'</td>
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
                      <td>'.$model.'</td>
                      <td>'.$process.'</td>
                      <td>'.$processno.'</td>
                      <td>'.$series.'</td>
                      <td>'.$typetransfer.'</td>
                      <td>'.$category.'</td>
                      <td>'.$requestor.'</td>
                      <td>
                      ';
                    }

                    ?>
                    <div class="dropdown" >
                      <a class="btn btn-info btn-sm " href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="color:white">
                        Actions
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                           <a href="RequestDetails.php?reqID=<?php echo $requestID;?>" class="dropdown-item" style="color:blue;"><strong>View Details</strong></a>
                        </li>
                        <li>

                          <a href="#" onclick="
                      setTimeout(function() {
                       swal({
                        title: 'Request Approval',
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
                          window.location = 'process/mainProcess.php?function=requestApprove&reqID=<?php echo $requestID;?>';
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
                ?>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div><!-- End Recent Sales -->
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

<section>
  <div class="modal fade" id="viewDetails" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="viewDetails1"></div>

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
    $.ajax({url:"../modal/declineRequest.php?id="+id,cache:false,success:function(result){
          $(".declineRequest1").html(result);
    }});
  });
</script>
<script>
 
   $('table tbody').on('click', '.openModal1', function() {
    var id = $(this).attr('data-id');
    $.ajax({url:"../modal/viewDetails.php?id="+id,cache:false,success:function(result){
          $(".viewDetails1").html(result);
    }});
  });
</script>
</body>

</html>