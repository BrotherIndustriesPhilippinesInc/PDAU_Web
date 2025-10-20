  
            <div class="card-body">
              <!-- Floating Labels Form -->
              <form class="row g-3" name="create_new" id="create_new" method="POST" action="../process/mainProcess.php?function=create_new" enctype="multipart/form-data">
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="requestDate" id="requestDate" value="<?php echo $today_noTime; ?>" readonly>
                    <label for="floatingName">Requested Date</label>
                  </div>
                </div>
               
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" name="sciNo" class="form-control" id="sciNo" value="TBA" readonly title="SCI Document Number will be issued after the Manager's Approval">
                    <label for="floatingEmail">Document / SCI Number <span style="color: red;">(Not Official)</span></label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="revNo" name="revNo" value="00" readonly title="Not yet Official">
                    <label for="floatingEmail">Revision Number</label>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="request_section" name="request_section" placeholder="Section" readonly value="<?php echo $section ?>">
                    <label for="section">Section</label>
                  </div>
                </div>
                 <div class="col-md-6">
                  <div class="form-floating">
                    <input type="search" class="form-control" id="title" name="title" placeholder="Title" required oninput="this.value = this.value.toUpperCase();">
                    <label for="section"><strong><i class="bi bi-check2" style="color:red"></i> Title</strong></label>
                  </div>
                </div>
               <div class="col-md-4">
                    <div class="form-floating">
                      <input type="search" list="browModel" class="form-control prevent-select" id="model" name="model" placeholder="Select Model" autocomplete="off" required title="Input Model" oninput="this.value = this.value.toUpperCase();"> 
                      <label class="prevent-select" for="model"><strong><i class="bi bi-check2" style="color:red"></i> Model</strong></label>
                  </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browSPV" class="form-control prevent-select" id="select_spv" name="select_spv" placeholder="Select Supervisor" autocomplete="off" required title="Select Supervisor" onchange="checkSPV_new();"> 
                      <label for="select_spv"><strong><i class="bi bi-check2" style="color:red"></i> Supervisor</strong></label>
                      
                  </div>
                </div>

               <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browMGR" class="form-control prevent-select" id="select_mgr" name="select_mgr" placeholder="Select Manager" autocomplete="off" required title="Select Manager" onchange="checkMGR_new()">
                      <label class="prevent-select" for="select_mgr"><strong><i class="bi bi-check2" style="color:red"></i> Manager</strong></label>
                      
                  </div>
                </div>

                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="validity" id="permanent" value="Permanent" title="Check if document is Permanent">
                      <label class="form-check-label prevent-select" for="permanent">
                        Permanent
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="validity" id="temporary" value="Temporary" title="Check if document is Temporary">
                      <label class="form-check-label prevent-select" for="temporary">
                        Temporary
                      </label>
                    </div>
                    <div class="row mb-3">
                      <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="validity_date" id="validity_date" readonly min="<?php echo $next_due_date; ?>" onkeydown="return false">
                      </div>
                    </div>
                  </div>

                 <div class="col-md-6">
                  <label for="inputNumber" class="col-sm-6 col-form-label prevent-select"><strong><i class="bi bi-check2" style="color:red"></i> SCI Attachment</strong></label>
                  <div class="col-12">
                    <input class="form-control" type="file" id="file" name="file" onchange="verifyExcel()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required title="SCI File is required">
                  </div>
                </div>

               
                 <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control prevent-select" placeholder="Request Details" name="details" id="details" style="height: 100px;"title="Please indicate the reason or details of request"></textarea>
                    <label for="details"><strong><i class="bi bi-check2" style="color:red"></i> Request Details</strong></label>
                  </div>
                </div>

                <?php
                if ($accounttype != 'COMMON') {
                  ?>
                  <div class="text-center">
                    <button type="reset" class="btn btn-lg btn-danger" name="btnReset">Reset Inputs</button>
                    <button type="button" id="btnNew" onclick="confirm_new()" class="btn btn-lg btn-success">Submit New Request</button>
                  </div>
                  <?php
                }
                ?>

             

              </form><!-- End floating Labels Form -->

            </div>
<!-- <script type="text/javascript">
  document.addEventListener('keypress', (event)=>{

 let keyCode = event.keyCode ? event.keyCode : event.which;

 if(keyCode === 13) {
   document.getElementById('btnNew').click();
 }
 
});
</script> -->