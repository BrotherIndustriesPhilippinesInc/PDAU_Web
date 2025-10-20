  
            <div class="card-body">
              <!-- Floating Labels Form -->
              <form class="row g-3" name="reapply_new" id="reapply_new" method="POST" action="../process/mainProcess.php?function=reapply_new&requestID=<?php echo $requestID?>" enctype="multipart/form-data">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="requestDate" id="requestDate" value="<?php echo $today_noTime; ?>" readonly>
                    <label for="floatingName">Requested Date</label>
                  </div>
                </div>
               
                <div class="col-md-4">
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
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required oninput="this.value = this.value.toUpperCase();" value="<?php echo $Title ?>">
                    <label for="section"><strong><i class="bi bi-check2" style="color:red"></i> Title</strong></label>
                  </div>
                </div>
               <div class="col-md-4">
                    <div class="form-floating">
                      <input type="search" list="browModel" class="form-control prevent-select" id="model" name="model" placeholder="Select Model" autocomplete="off" required title="Input Model" oninput="this.value = this.value.toUpperCase();" value="<?php echo $Model ?>"> 
                      <label class="prevent-select" for="model"><strong><i class="bi bi-check2" style="color:red"></i> Model</strong></label>
                  </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browSPV" class="form-control prevent-select" id="select_spv" name="select_spv" placeholder="Select Supervisor" autocomplete="off" required title="Select Supervisor" value="<?php echo $SPV ?>" onchange="checkSPV_new();"> 
                      <label for="select_spv"><strong><i class="bi bi-check2" style="color:red"></i> Supervisor</strong></label>
                  </div>
                </div>

               <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browMGR" class="form-control prevent-select" id="select_mgr" name="select_mgr" placeholder="Select Manager" autocomplete="off" required title="Select Manager" value="<?php echo $MGR ?>" onchange="checkMGR_new();"> 
                      <label class="prevent-select" for="select_mgr"><strong><i class="bi bi-check2" style="color:red"></i> Manager</strong></label>
                  </div>
                </div>

                  <div class="col-md-6">
                    <div class="form-check">
                      <?php
                      if ($Validity == 'Permanent') {
                        ?>
                        <input class="form-check-input" checked type="radio" name="validity" id="permanent" value="Permanent" title="Check if document is Permanent">
                        <?php
                      }
                      else{
                        ?>
                         <input class="form-check-input" type="radio" name="validity" id="permanent" value="Permanent" title="Check if document is Permanent">
                        <?php
                      }
                      ?>
                      <label class="form-check-label prevent-select" for="permanent">
                        Permanent
                      </label>
                    </div>
                    <div class="form-check">
                      <?php
                      if ($Validity == 'Temporary') {
                        ?>
                        <input class="form-check-input" checked type="radio" name="validity" id="temporary" value="Temporary" title="Check if document is Temporary">
                        <label class="form-check-label prevent-select" for="temporary">
                          Temporary
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                        <div class="col-sm-6">
                          <input type="date" class="form-control" name="validity_date" id="validity_date" value="<?php echo $ValidityDate; ?>" required>
                        </div>
                      </div>
                        <?php
                      }
                      else{
                        ?>
                        <input class="form-check-input" type="radio" name="validity" id="temporary" value="Temporary" title="Check if document is Temporary">
                        <label class="form-check-label prevent-select" for="temporary">
                          Temporary
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="validity_date" id="validity_date" readonly value="-" min="<?php echo $next_due_date; ?>" onkeydown="return false">
                        </div>
                      </div>
                        <?php
                      }
                      ?>
                    
                  </div>

                 <div class="col-md-6">
                  <label for="inputNumber" class="col-sm-6 col-form-label prevent-select"><strong><i class="bi bi-check2" style="color:red"></i> SCI Attachment</strong></label>
                  <div class="col-12">
                    <input class="form-control" type="file" id="file" name="file" onchange="verifyExcel()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required title="SCI File is required">
                  </div>
                </div>


                 <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control prevent-select" placeholder="Request Details" name="details" id="details" style="height: 100px;"title="Please indicate the reason or details of request"><?php echo $RequestDetails ?></textarea>
                    <label for="details"><strong><i class="bi bi-check2" style="color:red"></i> Request Details</strong></label>
                  </div>
                </div>

                 <input type="text" id="reqNew" name="reqNew" value="reapply" style="width: 100px;" hidden> 

                <div class="text-center">
                  <a href="#" class="btn btn-lg btn-danger" onclick="cancelReApply();">Cancel Re-apply</a>

                  <button type="button" onclick="confirm_new()" class="btn btn-lg btn-success">Submit Re-apply</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>

