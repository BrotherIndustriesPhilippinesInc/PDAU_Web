
            <div class="card-body">
              <!-- Floating Labels Form -->
              <form class="row g-3" name="reapply_abo" id="reapply_abo" method="POST" action="../process/mainProcess.php?function=reapply_abo&requestID=<?php echo $requestID; ?>" enctype="multipart/form-data">
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="requestDate" id="requestDate" value="<?php echo $today_noTime; ?>" readonly>
                    <label for="floatingName">Requested Date</label>
                  </div>
                </div>

                <div class="col-md-5">
                    <div class="form-floating">
                      <input type="search" list="browSCI" class="form-control prevent-select" id="sciNo_abo" name="sciNo_abo" placeholder="Select Document / SCI Number" autocomplete="off" required title="Select Document / SCI Number" oninput="this.value = this.value.toUpperCase();" onchange="checkSCI_abo();" value="<?php echo $SCINo; ?>" readonly> 
                      <label class="prevent-select" for="model"><strong><i class="bi bi-check2" style="color:red"></i> Document / SCI Number</strong></label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="revNo_abo" name="revNo_abo" readonly title="Not yet Official" value="<?php echo $RevNo; ?>" > 
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
                    <input type="text" class="form-control" id="title_abo" name="title_abo"  placeholder="Title" readonly value="<?php echo $Title; ?>" > 
                    <label for="section"><strong>Title</strong></label>
                  </div>
                </div>
               <div class="col-md-4">
                    <div class="form-floating">
                     <input type="text" class="form-control" id="model_abo" name="model_abo"  placeholder="Title" readonly value="<?php echo $Model; ?>" >  
                      <label class="prevent-select" for="model_abo"><strong>Model</strong></label>
                  </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browSPV" class="form-control prevent-select" id="select_spv_abo" name="select_spv_abo" placeholder="Select Supervisor" autocomplete="off" required title="Select Supervisor" value="<?php echo $SPV; ?>" onchange="checkSPV_abo();">
                      <label for="select_spv_abo"><strong><i class="bi bi-check2" style="color:red"></i> Supervisor</strong></label>
                  </div>
                </div>

               <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="browMGR" class="form-control prevent-select" id="select_mgr_abo" name="select_mgr_abo" placeholder="Select Manager" autocomplete="off" required title="Select Manager" value="<?php echo $MGR; ?>" onchange="checkMGR_abo();"> 
                      <label class="prevent-select" for="select_mgr_abo"><strong><i class="bi bi-check2" style="color:red"></i> Manager</strong></label>
                  </div>
                </div>


                <div class="col-md-3">
                    <div class="form-floating">
                     <input type="text" class="form-control" id="validity_abo" name="validity_abo"  placeholder="Validity" readonly value="<?php echo $Validity; ?>" >
                      <label class="prevent-select" for="validity_abo"><strong>Validity</strong></label>
                  </div>
                </div>
                   <div class="col-md-3">
                    <div class="form-floating">
                     <input type="text" class="form-control" id="validity_date_abo" name="validity_date_abo"  placeholder="Validity Date" readonly value="<?php echo $ValidityDate; ?>" > 
                      <label class="prevent-select" for="validity_date_abo"><strong>Validity Date</strong></label>
                  </div>
                </div>

                <div class="col-md-6">
                   <div class="input-group mb-3">
                      <input type="text" class="form-control" name="sciFile" id="sciFile" placeholder="File Name" aria-label="Username" readonly aria-describedby="basic-addon1" value="<?php echo $SCIExcel; ?>"  style="height: 58px;">
                       <button type="button" onclick="openFile();" id="btnSCIFile" name="btnSCIFile" class="btn btn-success btn-sm" disabled>View SCI File</button>
                    </div>
                </div>

                   
                 <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control prevent-select" placeholder="Request Details" name="details_abo" id="details_abo" style="height: 100px;"title="Please indicate the reason or details of request"><?php echo $SCIExcel; ?></textarea>
                    <label for="details"><strong><i class="bi bi-check2" style="color:red"></i> Abolition Details</strong></label>
                  </div>
                </div>

                <?php
                if ($accounttype != 'COMMON') {
                  ?>
                 <div class="text-center">
                   <a href="#" class="btn btn-lg btn-danger" onclick="cancelReApply();">Cancel Re-apply</a>
                  <button type="button" onclick="confirm_abo()" class="btn btn-lg btn-warning">Submit Abolition Request</button>
                </div>
                  <?php
                }
                ?>


        <!--         <div class="col-md-12">
                	<label for="inputNumber" class="col-sm-6 col-form-label prevent-select"><strong> SCI Document</strong></label>
                	<div class="col-12">
                		<iframe height="500px"  class="form-control" src="../attachment/202303171022-WP202202711.pdf"></iframe>
                	</div>
                </div> -->

               
              </form><!-- End floating Labels Form -->

            </div>
