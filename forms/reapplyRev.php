  
            <div class="card-body">
              <!-- Floating Labels Form -->
              <form class="row g-3" name="reapply_rev" id="reapply_rev" method="POST" action="../process/mainProcess.php?function=reapply_rev&requestID=<?php echo $requestID; ?>" enctype="multipart/form-data">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="requestDate" id="requestDate" value="<?php echo $today_noTime; ?>" readonly>
                    <label for="floatingName">Requested Date</label>
                  </div>
                </div>
               
                <div class="col-md-4">
                    <div class="form-floating">
                      <input type="search" list="browSCI" class="form-control prevent-select" id="sciNo_rev" name="sciNo_rev" placeholder="Select Document / SCI Number" autocomplete="off" required title="Select Document / SCI Number" oninput="this.value = this.value.toUpperCase();" onchange="checkSCI_rev();" value="<?php echo $SCINo; ?>" readonly> 
                      <label class="prevent-select" for="model"><strong><i class="bi bi-check2" style="color:red"></i> Document / SCI Number</strong></label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="revNo_rev" name="revNo_rev" readonly value="<?php echo $RevNo ?>">
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
                    <input type="text" class="form-control" id="title_rev" name="title_rev"  placeholder="Title" required oninput="this.value = this.value.toUpperCase();" value="<?php echo $Title ?>" required>
                    <label for="section"><strong><i class="bi bi-check2" style="color:red"></i> Title</strong></label>
                  </div>
                </div>
               <div class="col-md-4">
                    <div class="form-floating">
                      <input type="search" list="browModel" class="form-control prevent-select" id="model_rev" name="model_rev" placeholder="Select Model" autocomplete="off" required title="Input Model" oninput="this.value = this.value.toUpperCase();" value="<?php echo $Model ?>">
                      <label class="prevent-select" for="model"><strong><i class="bi bi-check2" style="color:red"></i> Model</strong></label>
                  </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browSPV" class="form-control prevent-select" id="select_spv_rev" name="select_spv_rev" placeholder="Select Supervisor" autocomplete="off" required title="Select Supervisor" value="<?php echo $SPV ?>" onchange="checkSPV_rev();">
                      <label for="select_spv"><strong><i class="bi bi-check2" style="color:red"></i> Supervisor</strong></label>
                  </div>
                </div>

               <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browMGR" class="form-control prevent-select" id="select_mgr_rev" name="select_mgr_rev" placeholder="Select Manager" autocomplete="off" required title="Select Manager" value="<?php echo $MGR ?>" onchange="checkMGR_rev();">
                      <label class="prevent-select" for="select_mgr"><strong><i class="bi bi-check2" style="color:red"></i> Manager</strong></label>
                  </div>
                </div>

                  <div class="col-md-6">
                    <div class="form-check">
                      <?php
                      if ($Validity == 'Permanent') {
                        ?>
                        <input class="form-check-input" checked type="radio" name="validity_rev" id="permanent_rev" value="Permanent" title="Check if document is Permanent">
                        <?php
                      }
                      else{
                        ?>
                         <input class="form-check-input" type="radio" name="validity_rev" id="permanent_rev" value="Permanent" title="Check if document is Permanent">
                        <?php
                      }
                      ?>
                      <label class="form-check-label prevent-select" for="permanent_rev">
                        Permanent
                      </label>
                    </div>


                    <div class="form-check">
                      <?php
                      if ($Validity == 'Temporary') {
                        ?>
                        <input class="form-check-input" checked type="radio" name="validity_rev" id="temporary_rev" value="Temporary" title="Check if document is Temporary">
                        <label class="form-check-label prevent-select" for="temporary_rev">
                          Temporary
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                        <div class="col-sm-6">
                          <input type="date" class="form-control" name="validity_date_rev" id="validity_date_rev" value="<?php echo $ValidityDate; ?>" required>
                        </div>
                      </div>
                        <?php
                      }
                      else{
                        ?>
                        <input class="form-check-input" type="radio" name="validity_rev" id="temporary_rev" value="Temporary" title="Check if document is Temporary">
                        <label class="form-check-label prevent-select" for="temporary_rev">
                          Temporary
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="validity_date_rev" id="validity_date_rev" readonly value="-" min="<?php echo $next_due_date; ?>" onkeydown="return false">
                        </div>
                      </div>
                        <?php
                      }
                      ?>
                    
                  </div>


                 <div class="col-md-6">
                  <label for="inputNumber" class="col-sm-6 col-form-label prevent-select"><strong><i class="bi bi-check2" style="color:red"></i> SCI Attachment</strong></label>
                  <div class="col-12">
                    <input class="form-control" type="file" id="file_rev" name="file_rev" onchange="verifyExcelRev()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required title="SCI File is required">
                  </div>
                </div>


                 <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control prevent-select" placeholder="Request Details" name="details_rev" id="details_rev" style="height: 100px;"title="Please indicate the reason or details of request"><?php echo $RequestDetails ?></textarea>
                    <label for="details"><strong><i class="bi bi-check2" style="color:red"></i> Request Details</strong></label>
                  </div>
                </div>

                <div class="text-center">
                    <a href="#" class="btn btn-lg btn-danger" onclick="cancelReApply();">Cancel Re-apply</a>
                  <button type="button" onclick="confirm_rev()" class="btn btn-lg btn-primary">Submit Revision Request</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>