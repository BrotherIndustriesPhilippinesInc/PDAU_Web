<section>
  <div class="modal fade" id="newAccount" tabindex="-1" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register New Account</h5>
        </div>
        <div class="modal-body">
          <form method="POST" action="../process/mainProcess.php?function=newAccount" name="addUser" id="addUser">
            <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>BIPH-ID:</b></label>
              <div class="col-sm-9">
                <input type="search" list="brow1" class="form-control" id="biph_id" name="biph_id" placeholder="Select your Employee ID" style="text-transform: uppercase;" onchange="checkID();"> 
                <datalist id="brow1">
                 <?php
                 /*$sql = "SELECT DISTINCT EmpNo, Full_Name FROM EmployeeDetails WHERE ADID is not null ORDER BY EmpNo ASC ";*/
                 $sql = "SELECT DISTINCT EmpNo, Full_Name FROM EmployeeDetails ORDER BY EmpNo ASC ";
                 $stmt = sqlsrv_query($conn2,$sql);
                 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  echo '<option value="'.$row['EmpNo'].'">'.$row['Full_Name'].'</option>';
                }
                ?>
              </datalist> 
              </div>
            </div>
            <br>
              <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>ADID:</b></label>
              <div class="col-sm-9">
                <input type="text" name="adid" class="form-control" id="adid" readonly>
              </div>
            </div>
             <br>
            <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>FullName:</b></label>
              <div class="col-sm-9">
                <input type="text" name="fullname" class="form-control" id="fullname" readonly>
              </div>
            </div>
             <br>
              <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Department:</b></label>
              <div class="col-sm-9">
                <input type="text" name="dept" class="form-control" id="dept" readonly>
              </div>
            </div>
             <br>

             <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Section:</b></label>
              <div class="col-sm-9">
                <select name="section" class="form-control" id="section" readonly>
                  <option value="" disabled="" selected="">Select Section</option>
                  <?php
                  $sql = "SELECT DISTINCT Section FROM EmployeeDetails WHERE Section!='' OR Section is not null ORDER BY Section ASC ";
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
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Position/Acct.Type:</b></label>
              <div class="col-sm-9">
                <input type="text" name="position" class="form-control" id="position" readonly>
              </div>
            </div>
             <br>
            <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Email:</b></label>
              <div class="col-sm-9">
                <input type="text" name="emailadd" class="form-control" id="emailadd" readonly>
              </div>
            </div>
             <br>
             <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Default Password:</b></label>
              <div class="col-sm-9">
                <input type="text" name="pword" class="form-control" id="pword" readonly value="biph0301">
              </div>
            </div>
             <br>
              <div class="row mb-12">
              <label for="inputEmail3" class="col-sm-3 col-form-label"><b>Administrator ? </b></label>
              <div class="col-sm-9">
                <fieldset class="row mb-3">
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="accountCode" id="accountCode1" value="Yes">
                      <label class="form-check-label prevent-select" for="accountCode1">
                        Yes
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="accountCode" id="accountCode2" value="No">
                      <label class="form-check-label prevent-select" for="accountCode2">
                        No
                      </label>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
            <br>
           </form>
            <div class="text-center">
            <button type="cancel" name="btnCancel" id="btnCancel" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="btnSubmit" name="btnSubmit" onclick="confirm_submit()" class="btn btn-success btn-lg">Register</button>
            </div>
         
        </div>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">
  function checkID() {

     var adid= document.getElementById('adid');
      var fullname = document.getElementById('fullname');
      var dept = document.getElementById('dept');
      var section = document.getElementById('section');
      var position = document.getElementById('position');
      var emailadd = document.getElementById('emailadd');
      var biph_id = $('#biph_id').val();

      if (biph_id == null || biph_id == "") {
        document.addUser.biph_id.value = "";
        adid.value="";
        fullname.value="";
        dept.value="";
        section.value="";
        position.value="";
        emailadd.value="";
      }
      else{

        $.ajax({
          url:"../process/ajax_FetchRegister.php",
          method:"POST",
          data:{biph_id:biph_id},
          dataType:"JSON",
          success:function(data)
          {
            if (data.checkID == 1 && data.count == 0) {
              alert("BIPH ID is not valid. Please check your inputs.");
              document.addUser.biph_id.value = "";
              adid.value="";
              fullname.value="";
              dept.value="";
              section.value="";
              position.value="";
              emailadd.value="";
            }
           else if (data.checkID == 0 && data.count >= 1) {
              alert("User already registered.");
              document.addUser.biph_id.value = "";
              adid.value="";
              fullname.value="";
              dept.value="";
              section.value="";
              position.value="";
              emailadd.value="";
            }
            else{
              $('#adid').val(data.adid);
              $('#fullname').val(data.fullname);
              $('#dept').val(data.dept);
              $('#section').val(data.section);
              $('#position').val(data.position);
              $('#emailadd').val(data.emailadd);
               $('#btnSubmit').focus();
            }
          }
        });
      }


  }

  function confirm_submit() {

    var biph_id = $('#biph_id').val();
    var fullname = $('#fullname').val();

    $('#fullname').focus();

    if (biph_id == "" || biph_id == null)
    {
        swal({
          text: 'Selection required!',
          title: "Select BIPH ID", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        });
    }

    else if($('.form-check-input:checked').length < 1) {
      this.checked = false;
      setTimeout(function() {
        swal({
          text: 'Please choose if Account is Administrator',
          title: "Administrator", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
    }
    
    else{

       setTimeout(function() {
        swal({
          title: 'New Account',
          text: 'Are you sure you want to Register [ '+fullname+' ] as New Account ?',
          imageUrl: '../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: 'green',
          confirmButtonText: 'Yes, register it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
          
            document.getElementById("btnLoading").click();
             document.getElementById("addUser").submit();
          } else {
            
          }
        });
      }, 100);

            

    }

  }

</script>