<?php 
include '../global/conn.php';

session_start();

$id = $_GET['id'];

?>

     <div class="modal-header" >

        <h5 class="modal-title">SCI DOCUMENT LOGS: [ <?php echo $id; ?> ]

      </h5>
      <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel_func" name="cancel_func" style="float:right; width:55px;"><strong>X</strong></button>
      </div>
      <div class="modal-body">


       <div class="col-12">
         <table id="example1" class="table table-bordered table-hover" style="font-size: 13px;">
          <tr>
            <th>Date</th>
            <th>SCI No.</th>
            <th>Type</th>
            <th>RequestID</th>
            <th>Request Details</th>
            <th>Requestor</th>
            <th>SPV</th>
            <th>MGR</th>
            <th>Implemented</th>
          </tr>
          <tbody>
            <tr>
              <?php
              $sql = "SELECT * FROM SCI_DocumentLogs WHERE SCINo = '$id' ORDER BY ID DESC";
              $params = array();
              $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
              $stmt = sqlsrv_query( $conn2, $sql , $params, $options );
              $row_count = sqlsrv_num_rows( $stmt );
              while($row2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $logID = $row2['ID'];
                $TransactedDate = $row2['TransactedDate'];
                $SCINo = $row2['SCINo'];
                $RevNo = $row2['RevNo'];
                $DocType = $row2['DocType'];
                $RequestDetails = $row2['RequestDetails'];
                $Requestor = $row2['Requestor'];
                $RequestID = $row2['RequestID'];
                $SPV = $row2['SPV'];
                $MGR = $row2['MGR'];
                $ImplementedBy = $row2['ImplementedBy'];

                echo 
                '<td>'.$TransactedDate.'</td>
                <td>'.$SCINo.'-'.$RevNo.'</td>
                <td>'.$DocType.'</td>
                <td>'.$RequestID.'</td>
                <td>'.$RequestDetails.'</td>
                <td>'.$Requestor.'</td>
                <td>'.$SPV.'</td>
                <td>'.$MGR.'</td>
                <td>'.$ImplementedBy.'</td>

                ';
                ?>
                </tr>
                <?php
              }

              ?>
            
          </tbody>
          <?php
          if ($row_count<=0) {
            ?>
            <tfoot>
              <tr>
                <th colspan="9" style="text-align:center; font-size:15px;"><i>No data available.</i></th>
              </tr>
            </tfoot>
            <?php
          }
          ?>
      
        </table>
      </div>

        </div>