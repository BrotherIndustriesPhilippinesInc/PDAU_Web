<?php
session_start();
include '../global/conn.php';
include '../global/userInfo.php';
$title = 'accounts';


if ($accounttype != 'ADMIN') {
  header("Location:dashboard-sci.php");
}


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
      <h1>Accounts</h1>
    </div>
    <section>
      <!-- Recent Sales -->
      <div class="col-12">
        <div class="card recent-sales overflow-auto">
          <div class="card-body" style="min-height:400px;">
            <h5 class="card-title"><a class="btn btn-primary" href="exportAccounts.php"><i class="bi bi-file-earmark-spreadsheet"></i> Export to Excel</a>
              <?php if ($accountCode == 1): ?>
                <button style="float:right;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newAccount"><i class="bi bi-person"></i> Add New User</button>
                 <button class="btn btn-danger" type="button" onclick="verifyEmployeeSync();" hidden=""><i class="bi bi-arrow-repeat"></i> Employee Sync</button>
              <?php endif ?>
              
            </h5>
            <table class="table" id="example" style="font-size:14px;" name ="tblAccounts">
              <thead>
                <tr>
                  <th scope="col">BIPH-ID</th>
                  <th scope="col">ADID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Department</th>
                  <th scope="col">Section</th>
                  <th scope="col">Position</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
              
              
                $sql = "SELECT * FROM Accounts WHERE SystemNo = 2 ORDER BY BIPH_ID ASC ";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $biphid = $row['BIPH_ID'];
                  $adid = $row['UserADID'];
                  $name = $row['FullName'];
                  $dept = $row['Department'];
                  $section = $row['Section'];
                  $position = $row['AccountType'];
                  $status = $row['AccountStatus'];

               
                  echo '
                  <tr>
                  <td>'.$biphid.'</td>
                  <td>'.$adid.'</td>
                  <td>'.$name.'</td>
                  <td>'.$dept.'</td>
                  <td>'.$section.'</td>
                  <td>'.$position.'</td>';
                  if ($status == 'Active') {
                     echo '<td style="color:green;font-weight:700">'.$status.'</td>';
                  }
                  else{
                    echo '<td style="color:red;font-weight:700">'.$status.'</td>';
                  }
                  echo '
                  <td>
                  ';

                    ?>

                      <a class="btn btn-warning btn-sm " href="update-accounts.php?biphid=<?php echo $biphid ?>&number=1">
                        Details
                      </a>
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


<?php

require_once '../modal/newAccount.php';

?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>

 <script type="text/javascript">
   var table = $('#example').DataTable( {
    pageLength : 10,
    lengthMenu: [[10, 20, 30], [10, 20, 'All']]
  } )
 </script>

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


   function verifyEmployeeSync(){
    setTimeout(function() {
      swal({
        title: 'Employee Sync',
        text: 'Are you sure you want to run Employee Sync??',
        /*type: 'info',*/
        imageUrl:'../assets/img/question-red.png',
        showCancelButton: true,
        confirmButtonColor: 'green',
        confirmButtonText: 'Yes',
        cancelButtonColor: '#',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: true
      },
      function(isConfirm){
        if (isConfirm) {
          document.getElementById('btnLoading').click();
          window.location = '../process/mainProcess.php?function=employeeSync';
        } else {

        }
      });
    }, 100);
  }
</script>


</body>

</html>