<section>
  <div class="modal fade" id="abolished" tabindex="-1" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b> Abolished SCI </b></h5>
        </div>
        <div class="modal-body">
         <div class="col-12 overflow-auto">
                  <table id="example" class="table datatable"  style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Section</th>
                        <th scope="col">SCI No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Model</th>
                        <th scope="col">Validity</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                if ($section == 'Common') {
                  $sql = "SELECT * FROM SCI_MainData WHERE Status = 'Inactive' ORDER BY ID ASC";
                }
                else{
                  //$sql = "SELECT * FROM SCI_MainData WHERE Status = 'Inactive' AND Section = '$section' ORDER BY ID ASC";

                  $sql = "SELECT * 
                                  FROM SCI_Request
                                  WHERE (RequestSection = '$section'
                                        OR RequestSection IN (SELECT Section 
                                                              FROM AdditionalSection 
                                                              WHERE BIPH_ID = '$user_login'))
                                    AND Status = 'Inactive' ORDER BY ID ASC";
                }
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $DateModified = $row['DateModified'];
                  $Section = $row['Section'];
                  $SCINo = $row['SCINo'];
                  $RevNo = $row['RevNo'];
                  $Title = $row['Title'];
                  $Model = $row['Model'];
                  $Validity = $row['Validity'];
                  $ValidityDate = $row['ValidityDate'];
                  $IssuanceDate = $row['IssuanceDate'];
                  $SCIFile = $row['SCIFile'];
                  $Status = $row['Status'];

                    echo '
                    <tr>
                    <td>'.$DateModified.'</td>
                    <td>'.$Section.'</td>
                    <td>'.$SCINo.'-'.$RevNo.'</td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    <td>'.$Validity.'</td>
                   ';
                  
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

