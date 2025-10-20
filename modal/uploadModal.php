<section>
  <div class="modal fade" id="uploadData" tabindex="-1" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload Data</h5>
        </div>
        <div class="modal-body">
          <form method="POST" action="../process/mainProcess.php?function=uploadData" name="uploadDataForm" id="uploadDataForm" enctype="multipart/form-data">
            <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>SELECT SECTION:</b></label>
              <div class="col-sm-9">
                <select class="form-control" id="select_section" name="select_section" required="">
                  <option value="" selected="" disabled="">Select Section</option>
                 <?php
                 $sql = "SELECT DISTINCT Section FROM Accounts WHERE SystemNo = 2 ORDER BY Section ASC ";
                 $stmt = sqlsrv_query($conn2,$sql);
                 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  echo '<option>'.$row['Section'].'</option>';
                }
                ?>
                </select>
              </div>
            </div>
            <br>
              <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>EXCEL FILE:</b></label>
              <div class="col-sm-9">
                <input type="file" name="excelFile" class="form-control" id="excelFile" required="">
              </div>
            </div>
            <br>
           </form>
            <div class="text-center">
            <button type="cancel" name="btnCancel" id="btnCancel" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="btnSubmit" name="btnSubmit" onclick="confirm_upload()" class="btn btn-success btn-lg">Register</button>
            </div>
         
        </div>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">

  function confirm_upload() {

    var select_section = $('#select_section').val();
    var excelFile = document.getElementById('excelFile');

    if (select_section == "" || select_section == null)
    {
      setTimeout(function() {
        swal({
          text: 'Selection required!',
          title: "Select Section", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#select_section').focus();
    }

    else if (document.getElementById('excelFile').files.length == 0)
    {
      setTimeout(function() {
        swal({
          text: 'Attachment required!',
          title: "SCI Data", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#excelFile').focus();
    }

    else{

      setTimeout(function() {
        swal({
          title: 'Upload Data',
          text: 'Are you sure you want to upload this data ?',
          imageUrl: '../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: 'green',
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.getElementById("btnLoading").click();
            document.getElementById("uploadDataForm").submit();
          } else {

          }
        });
      }, 100);

    }

  }

</script>