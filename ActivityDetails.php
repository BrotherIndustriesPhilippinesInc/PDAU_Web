<?php
session_start();
$title = 'processDetails';
$activityID = $_GET['auditID'];
$activityStatus = $_GET['status'];

include 'global/conn.php';
$sql = "SELECT * FROM Activity_MainData WHERE ActivityID = '$activityID'";
$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
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
  $ActivityDate = date('F d, Y', strtotime($ActivityDate));
  $FullName = utf8_encode($FullName);
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
<?php include 'global/head.php'; ?>
<body>

 <?php include 'global/header.php'; ?>

 <?php include 'global/sidebar.php'; ?>

 <main id="main" class="main">

  <div class="pagetitle">
    <h1><?php echo $activityID;?> - 
      <?php
      if ($activityStatus == "DONE") {
       echo '<span style="color:green">'.$activityStatus.'</span>';
      }
      elseif ($activityStatus == "ONGOING") {
        echo '<span style="color:blue">'.$activityStatus.'</span>';
      }
      elseif ($activityStatus == "CANCELLED") {
        echo '<span style="color:orange">'.$activityStatus.'</span>';
      }
      elseif ($activityStatus == "FAILED") {
        echo '<span style="color:red">'.$activityStatus.'</span>';
      }
      ?>
      <button  class="btn btn-primary" style="float: right;" onclick="history.go(-1)">Back</button>
    </h1>
    <br>

  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
          <div class="card-body" style="min-height:350px;">
            <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <!-- Vertical Form -->
              <form class="row g-3">
                <div class="col-3">
                  <label for="inputNanme4" class="form-label">Activity Date:</label>
                  <input type="text" class="form-control" id="efPic" readonly value="<?php echo $ActivityDate;?>">
                </div>
                <div class="col-3">
                  <label for="inputEmail4" class="form-label">Activity ID:</label>
                  <input type="text" class="form-control" id="efdate" readonly value="<?php echo $activityID;?>">
                </div>
                <div class="col-3">
                  <label for="inputEmail4" class="form-label">BIPH ID:</label>
                  <input type="text" class="form-control" id="efdate" readonly value="<?php echo $BIPHID;?>">
                </div>
                <div class="col-3">
                  <label for="inputEmail4" class="form-label">Operator's Name:</label>
                  <input type="text" class="form-control" id="efdate" readonly value="<?php echo $FullName;?>">
                </div>
                <div class="col-3">
                  <label for="inputPassword4" class="form-label">Department:</label>
                  <input type="text" class="form-control" id="staff" readonly value="<?php echo $Department;?>">
                </div>
                <div class="col-3">
                  <label for="inputAddress" class="form-label">Section:</label>
                  <input type="text" class="form-control" id="staffDate" readonly value="<?php echo $Section;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Line:</label>
                  <input type="text" class="form-control" id="spv" readonly value="<?php echo $Line;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Model:</label>
                  <input type="text" class="form-control" id="spvDate" readonly value="<?php echo $Model;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Process</label>
                  <input type="text" class="form-control" id="mng" readonly value="<?php echo $Process;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Process No:</label>
                  <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $ProcessNo;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Purpose:</label>
                   <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $Purpose;?>">
                </div>
                 <div class="col-3">
                  <label for="inputAddress" class="form-label">Examiner:</label><br>
                   <input type="text" class="form-control" id="mngDate" readonly value="<?php echo $Examiner;?>">
                </div>
              </form><!-- Vertical Form -->
            </div>
          </div>
        </div>

            <table class="table table-bordered" style="font-size:13px;">
              <thead>
                <tr>
                  <th scope="col">Series No</th>
                  <th scope="col">Keypoint1</th>
                  <th scope="col">ControlItem1</th>
                  <th scope="col">Keypoint2</th>
                  <th scope="col">ControlItem2</th>
                  <th scope="col">Keypoint3</th>
                  <th scope="col">ControlItem3</th>
                  <th scope="col" style="text-align:center">FinalResult</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include 'global/conn.php';
                $sql = "SELECT * FROM Activity_Details WHERE ActivityID = '$activityID'";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $SequenceNo = $row['SequenceNo'];
                  $Keypoint1 = $row['Keypoint1'];
                  $ControlItem1 = $row['ControlItem1'];
                  $Keypoint2 = $row['Keypoint2'];
                  $ControlItem2 = $row['ControlItem2'];
                  $Keypoint3 = $row['Keypoint3'];
                  $ControlItem3 = $row['ControlItem3'];
                  $FinalResult = $row['FinalResult'];
                
              
                echo '
                <td>'.$SequenceNo.'</td>
                <td>'.$Keypoint1.'</td>
                <td>'.$ControlItem1.'</td>
                <td>'.$Keypoint2.'</td>
                <td>'.$ControlItem2.'</td>
                <td>'.$Keypoint3.'</td>
                <td>'.$ControlItem3.'</td>
                
                ';
                if ($FinalResult == "Good") {
                  echo '<td style="text-align:center; color:green"><b>'.$FinalResult.'</b></td>';
                }
                elseif (($FinalResult == "No Good")) {
                  echo '<td style="text-align:center; color:red"><b>'.$FinalResult.'</b></td>';
                }
                ?>
              </tr>
              <?php
            }
              ?>
            </tbody>
          </table>



</div>
</div>
</section>

<section>
  <div class="modal fade" id="modalHistory" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="viewHistory"></div>

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
<?php include 'global/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include 'global/scripts.php'; ?>

<script>
  $('.openModal').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"modal/ProcessDecline.php?id="+id,cache:false,success:function(result){
      $(".declineRequest1").html(result);
    }});
  });
</script>

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({url:"modal/historyModal.php?id="+id,cache:false,success:function(result){
          $(".viewHistory").html(result);
      }});
  });
</script>
</body>

</html>