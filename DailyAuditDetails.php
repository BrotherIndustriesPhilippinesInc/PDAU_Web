<?php
$title = 'dailyAudit';

date_default_timezone_set('Asia/Singapore');
$today = date("Y-m-d");

$auditID = $_GET['auditID'];
$auditStat = $_GET['status'];
/*$audit_date_view = date('F d, Y', strtotime($audit_date));*/


if ($auditID == "" && $auditStat == "" || $auditID == null && $auditStat == null) {
  header("Location:dailyAudit.php?date=$today");
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
                    <h5 class="card-title text-center pb-100 fs-2">Daily Audit [<?php echo $auditID; ?>]
                    </h5>
                  </div>
                  <button type="button" id="filter" class="btn btn-danger btn-sm" onclick="history.go(-1)" style="float: right;">Back</button>
                  <br>
                  <table class="table table-bordered border-secondary" style="font-size: 15px;">
                    <thead>
                      <tr style="border:1px solid black;">
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Jig Code</th>
                        <th scope="col"style="font-size: 20px;background-color: #ffb84d">Jig Name</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Work I</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Condition</th>
                        <th scope="col" style="font-size:20px;background-color: #ffb84d;">Status</th>
                        <th colspan="4" scope="col" style="font-size:20px;background-color: #ffb84d; text-align: center;">Operator Using</th>
                      </tr>
                    </thead>
                    <thead>
                      <tr style="border:1px solid black;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Using</th>
                        <th>OperatorID</th>
                        <th>OperatorName</th>
                        <th>Reason</th>
                      </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                  <?php
                  include 'global/conn.php';

                  $sql = "SELECT * FROM JigAudit_Details WHERE JigAuditID = '$auditID' ORDER BY ID";
                  $params = array();
                  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                  $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
                  $row_count = sqlsrv_num_rows( $stmt );

                  while($resultQuery = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $JigCode = $resultQuery['JigCode'];
                    $JigName = $resultQuery['JigName'];
                    $WorkInstruction = $resultQuery['WorkInstruction'];
                    $Status = $resultQuery['Status'];
                    $OperatorUsing = $resultQuery['OperatorUsing'];
                    $Condition = $resultQuery['Condition'];
                    $OperatorID = $resultQuery['OperatorID'];
                    $OperatorName = $resultQuery['OperatorName'];
                    $Reason = $resultQuery['Reason'];
                    $OperatorName = utf8_encode($OperatorName);

                      if ($Status == "NG") {
                        $OperatorUsing = "-"; 
                        $OperatorID = "-";
                        $OperatorName = "-";
                        $Reason = "-";         
                        $Condition = "-";            
                      }
                      

                      echo "
                      <tr>
                      <td>".$JigCode."</td>
                      <td>".$JigName."</td>
                      <td>".$WorkInstruction."</td>
                      <td>".$Condition."</td>
                      <td>".$Status."</td>
                       <td>".$OperatorUsing."</td>
                      ";
                      if ($OperatorUsing == 'Yes') {
                        echo "
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        ";
                      }
                      else {
                        echo "
                        <td>".$OperatorID."</td>
                        <td>".$OperatorName."</td>
                        <td>".$Reason."</td>
                        ";
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
        <form action="dailyAudit.php?year=year_select">
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Select Date:</label>
            <div class="col-sm-9">
              <input type="date" name="date" id="date" class="form-control" required value="<?php echo $audit_date;?>">
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