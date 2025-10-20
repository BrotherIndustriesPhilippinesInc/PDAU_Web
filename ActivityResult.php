<?php
$title = 'ActivityResult';

date_default_timezone_set('Asia/Singapore');
$today = date("Y-m-d");

$audit_date = $_GET['date'];
$audit_date_view = date('F d, Y - l', strtotime($audit_date));


if ($audit_date == "" || $audit_date == null) {
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
                    <h5 class="card-title text-center pb-100 fs-2">Activity Checklist [<?php echo $audit_date_view; ?>]
                    </h5>
                  </div>
                  <button type="button" id="filter" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomer" style="float: right;">Filter Date</button>
                  <br>
                  <table class="table table-bordered border-secondary" style="font-size: 15px;">
                    <thead>
                      <tr style="border:1px solid black;">
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">ActID</th>
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Examiner</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Model</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Line</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Process</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">ProcessNo</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Purpose</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Status</th>
                        <th colspan="3" scope="col"style="font-size: 20px; text-align: center;background-color: #b3ccff">Operator</th>
                      </tr>
                    </thead>
                    <thead>
                      <tr style="border:1px solid black;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>BIPH-ID</th>
                        <th>Name</th>
                        <th>Section</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                  <?php
                  include 'global/conn.php';

                  $sql = "SELECT * FROM Activity_MainData WHERE ActivityDate = '$audit_date' ORDER BY ActivityID";
                  $params = array();
                  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                  $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
                  $row_count = sqlsrv_num_rows( $stmt );

                  while($resultQuery = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $ActivityID = $resultQuery['ActivityID'];
                    $BIPHID = $resultQuery['BIPHID'];
                    $FullName = $resultQuery['FullName'];
                    $Department = $resultQuery['Department'];
                    $Section = $resultQuery['Section'];
                    $Line = $resultQuery['Line'];
                    $Model = $resultQuery['Model'];
                    $Process = $resultQuery['Process'];
                    $ProcessNo = $resultQuery['ProcessNo'];
                    $Purpose = $resultQuery['Purpose'];
                    $Examiner = $resultQuery['Examiner'];
                    $Status = $resultQuery['Status'];
                    $FullName = utf8_encode($FullName);
                    $Examiner = utf8_encode($Examiner);
                      echo "
                      <tr>
                      <td> <a href='ActivityDetails2.php?auditID=".$ActivityID."&status=".$Status."'>".$ActivityID."</a></td>
                      <td>".$Examiner."</td>
                      <td>".$Model."</td>
                      <td>".$Line."</td>
                      <td>".$Process."</td>
                      <td>".$ProcessNo."</td>
                      <td>".$Purpose."</td>
                      ";
                      if ($Status == "DONE") {
                        echo '<td style="text-align:center; color:green"><b>'.$Status.'</b></td>';
                      }
                      elseif ($Status == "CANCELLED") {
                        echo '<td style="text-align:center; color:orange"><b>'.$Status.'</b></td>';
                      }
                      elseif ($Status == "FAILED") {
                        echo '<td style="text-align:center; color:red"><b>'.$Status.'</b></td>';
                      }
                      echo"
                      <td>".$BIPHID."</td>
                      <td>".$FullName."</td>
                      <td>".$Section."</td>
                      ";
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