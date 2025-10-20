<div class="modal-header">
  <h5 class="modal-title">Request History</h5>
</div>
<div class="modal-body modal-xl">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Event</th>
        <th scope="col">PIC</th>
      </tr>
    </thead>
    <tbody style="font-size: 13px;">
      <?php
      include '../global/conn.php';
      $id = $_GET['id'];
      $sql = "SELECT * FROM RequestLogs WHERE RequestID = '".$id."' ORDER BY ID DESC ";
      $stmt = sqlsrv_query($conn2,$sql);
      while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $transdate = $row['TransactionDate'];
        $event = $row['Event'];
        $pic = $row['AccountName'];
        $requestID = $row['RequestID'];
       /* $transdate = date('M d, Y', strtotime($transdate));*/
        echo '
        <tr>
        <td>'.$transdate.'</td>
        <td>'.$event.'</td>
        <td>'.$pic.'</td>
        ';

        ?>
        <?php
      }
      ?>
    </td>
  </tr>
</tbody>
</table>

</div>





