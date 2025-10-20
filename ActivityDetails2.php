<?php

$title = 'ActivityResult';
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

date_default_timezone_set('Asia/Singapore');
$today = date("Y-m-d");


if ($activityID == "" && $activityStatus =="") {
  header("Location:ActivityResult.php?date=$today");
}

include 'global/conn.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'global/head.php' ?>


<body>

  <main>
    <div class="container">

      <section class="section register min-vh-1000 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-12">

              <div class="card mb-12">

                <div class="card-body overflow-auto">

                  <div class="pt-12 pb-12">
                    <h5 class="card-title text-center pb-100 fs-2"><?php echo $activityID; echo " - ";?>
                    <?php
                    if ($activityStatus == "DONE") {
                      echo '<span style="color:green; font-size:32px;">DONE</span>';
                    }
                    elseif ($activityStatus == "CANCELLED") {
                       echo '<span style="color:orange; font-size:32px;">CANCELLED</span>';
                    }
                     elseif ($activityStatus == "FAILED") {
                       echo '<span style="color:red; font-size:32px;">FAILED</span>';
                    }
                       elseif ($activityStatus == "ONGOING") {
                       echo '<span style="color:blue; font-size:32px;">ONGOING</span>';
                    }
                    ?>
                    </h5>
                  </div>
             <button type="button" id="filter" class="btn btn-danger btn-sm" onclick="history.go(-1)" style="float: right;">Back</button>
                  <br>
                  <table class="table table-bordered border-secondary" style="font-size: 15px;">
                    <thead>
                      <tr style="border:1px solid black;">
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">SeriesNo</th>
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Keypoint1</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">ControlItem1</th>
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Keypoint2</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">ControlItem2</th>
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Keypoint3</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">ControlItem3</th>
                        <th scope="col"style="font-size: 20px; text-align: center;background-color: #b3ccff">FinalResult</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                  <?php
                  include 'global/conn.php';

                  $sql = "SELECT * FROM Activity_Details WHERE ActivityID = '$activityID' ORDER BY SequenceNo ASC";
                  $params = array();
                  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                  $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
                  $row_count = sqlsrv_num_rows( $stmt );

                  while($resultQuery = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $ActivityID = $resultQuery['ActivityID'];
                    $SequenceNo = $resultQuery['SequenceNo'];
                    $Keypoint1 = $resultQuery['Keypoint1'];
                    $ControlItem1 = $resultQuery['ControlItem1'];
                    $Keypoint2 = $resultQuery['Keypoint2'];
                    $ControlItem2 = $resultQuery['ControlItem2'];
                    $Keypoint3 = $resultQuery['Keypoint3'];
                    $ControlItem3 = $resultQuery['ControlItem3'];
                    $FinalResult = $resultQuery['FinalResult'];
                      echo "
                      <tr>
                      <td>".$SequenceNo."</td>
                      <td>".$Keypoint1."</td>
                      <td>".$ControlItem1."</td>
                      <td>".$Keypoint2."</td>
                      <td>".$ControlItem2."</td>
                      <td>".$Keypoint3."</td>
                      <td>".$ControlItem3."</td>
                      ";
                      if ($FinalResult == "Good") {
                        echo '<td style="text-align:center; color:green"><b>'.$FinalResult.'</b></td>';
                      }
                      elseif (($FinalResult == "No Good")) {
                        echo '<td style="text-align:center; color:red"><b>'.$FinalResult.'</b></td>';
                      }
                      ?>
                      <?php
                    }
              ?>

                    </tr>
                      </ul>
                    </div>
                    <span>No of Records:  <?php echo $row_count; ?>
                    </tbody></span>
                  </table>

                </div>
              </div>


            </div>
          </div>
        </div>
<section>
<div class="modal fade" id="addCustomer" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Date</h5>
      </div>
      <div class="modal-body">
        <form action="ActivityResult.php">
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Select Date:</label>
            <div class="col-sm-9">
              <input type="date" name="date" id="date" max="<?php echo $today;?>" class="form-control" required value="<?php echo $audit_date;?>">
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
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php
include 'global/scripts.php';
?>

<!-- Bootstrap library -->

</body>

</html>