<section>
  <div class="modal fade" id="ongoing" tabindex="-1" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b> Ongoing Request </b></h5>
        </div>
        <div class="modal-body">
         <div class="col-12 overflow-auto">
                  <table id="example" class="table datatable"  style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">RequestID</th>
                        <th scope="col">Type</th>
                        <th scope="col">SCI No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Model</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                if ($section == 'Common') {
                  $sql = "SELECT * FROM SCI_Request WHERE Status NOT IN ('APPROVED', 'CANCELLED') ORDER BY ID ASC";
               }
               else{
                 //$sql = "SELECT * FROM SCI_Request WHERE RequestSection = '$section' AND Status NOT IN ('APPROVED', 'CANCELLED') ORDER BY ID ASC";

                 $sql = "SELECT * 
                                  FROM SCI_Request
                                  WHERE (RequestSection = '$section'
                                        OR RequestSection IN (SELECT Section 
                                                              FROM AdditionalSection 
                                                              WHERE BIPH_ID = '$user_login'))
                                    AND Status NOT IN ('APPROVED', 'CANCELLED') ORDER BY ID ASC";
               }
               
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $RequestDate = $row['RequestDate'];
                  $RequestID = $row['RequestID'];
                  $RequestType = $row['RequestType'];
                  $SCINo = $row['SCINo'];
                  $RevNo = $row['RevNo'];
                  $Title = $row['Title'];
                  $Model = $row['Model'];
                  $SPV = $row['SPV'];
                  $MGR = $row['MGR'];
                  $Validity = $row['Validity'];
                  $ValidityDate = $row['ValidityDate'];
                  $RequestDetails = $row['RequestDetails'];
                  $Requestor = $row['Requestor'];
                  $RequestSection = $row['RequestSection'];
                  $SCIExcel = $row['SCIExcel'];
                  $SCIPDF = $row['SCIPDF'];
                  $SCIForProcess = $row['SCIForProcess'];
                  $Status = $row['Status'];
                  $Location = $row['Location'];

                  if ($RequestType == 'NEW') {
                    $SCINo_final = $SCINo;
                  }
                  else{
                    $SCINo_final = $SCINo.'-'.$RevNo;
                  }
                    echo '
                    <tr>
                    <td>'.$RequestDate.'</td>
                    <td>'.$RequestID.'</td>
                    <td><b>'.$RequestType.'</b></td>
                    <td>'.$SCINo_final.'</td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    ';
                    if ($Status == 'SPV APPROVAL' || $Status == 'MGR APPROVAL') {
                      echo '<td>
                      <a disabled style="color:#0d6efd" title="'.$Status.'"><b>'.$Status.'</b></a>
                      </td>
                       ';
                    }
                    elseif ($Status == 'DECLINED') {
                    echo '<td> <a  disabled style="color:#dc3545" title="'.$Status.'"  href="#"><b>'.$Status.'</b></a>';                   
                   }
                 
                   ?>
                   
                </tr>
                   <?php
                    }
                 ?>
                  
                    </tbody>

                  </table>


                </div>
            <br>
          
            <div class="text-center">
              <button type="button" name="btnCancel" id="btnCancel" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

