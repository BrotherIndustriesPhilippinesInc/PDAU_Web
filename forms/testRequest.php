<?php
include '../global/conn.php';
session_start();
$title = 'sciRequest';
$page = 'sci';

$a="0002";
$b="1";
$l=max(strlen($a),strlen($b));
$c=str_pad($a+$b, $l,"0", STR_PAD_LEFT);



    

    $sql = "SELECT COUNT(SCINo) as mainSCI FROM SCI_MainData WHERE Section = 'BPS'";
      $stmt = sqlsrv_query($conn2,$sql);
      while($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        $mainSCI = $row['mainSCI'];
        /*WALA SYANG RECORD SA MAIN DATA*/
        if ($mainSCI <=0) {

          $sql2 = "SELECT COUNT(SCINo) as reqSCI FROM SCI_Request WHERE RequestSection = 'BPS'";
          $stmt2 = sqlsrv_query($conn2,$sql2);
          while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
            $reqSCI = $row2['reqSCI'];
            /*WALA SYANG RECORD SA REQUEST DATA*/
            if ($reqSCI <=0) {
              $finalSCI = "SCI-BPS-0001";
            }
            /*MERON SYANG RECORD SA REQUEST DATA*/
            else{
             $sql3 = "SELECT TOP (1) SCINo as nextRequestSCI FROM SCI_Request WHERE Section = 'BPS' ORDER BY SCINo DESC";
             $stmt3 = sqlsrv_query($conn2,$sql3);
             while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
              $nextRequestSCI = $row3['nextRequestSCI'];

              $tempVar = substr($nextRequestSCI, 0,-4);
              $tempSCI= substr($nextRequestSCI, -4);
              $a=$tempSCI;
              $b="1";
              $l=max(strlen($a),strlen($b));
              $finalNo=str_pad($a+$b, $l,"0", STR_PAD_LEFT);
              $stand = $finalNo;

              $finalSCI = $tempVar.$stand;

            }
          }
        }
      }
      /*MERON SYANG RECORD SA MAIN DATA*/
      else{
               
      }




    }

























    /*WALA SYANG RECORD SA MAIN DATA*/
    if ($row_count <=0 || $row_count == null) {

    $sql2 = "SELECT * FROM SCI_Request WHERE Section = 'BPS'";
    $params2 = array();
    $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt2 = sqlsrv_query( $conn2, $sql2 , $params2, $options2 );
    $row_count2 = sqlsrv_num_rows( $stmt2 );
    /*WALA SYANG RECORD SA REQUEST DATA*/
    if ($row_count2<=0) {
      $finalSCI = "SCI-BPS-0001";
    }
    /*MERON SYANG RECORD SA REQUEST DATA*/
    else{
      $sql3 = "SELECT TOP 1 SCINo as nextRequestSCI FROM SCI_Request WHERE Section = 'BPS' ORDER BY SCINo DESC";
      $stmt3 = sqlsrv_query($conn2,$sql3);
      while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
        $nextRequestSCI = $row3['nextRequestSCI'];

        $tempVar = substr($nextRequestSCI, 0,-4);
        $tempSCI= substr($nextRequestSCI, -4);
        $a=$tempSCI;
        $b="1";
        $l=max(strlen($a),strlen($b));
        $finalNo=str_pad($a+$b, $l,"0", STR_PAD_LEFT);
        $stand = $finalNo;

        $finalSCI = $tempVar.$stand;
      }
    }

    }
    /*MERON SYANG RECORD SA MAIN PERO CHECHECK PA DIN SA REQUEST*/
    else{


    }









    /*GET LAST SCI FROM MAIN DATA*/
    $sql1 = "SELECT TOP(1) SCINo as mainSCI FROM SCI_MainData WHERE Section = 'BPS' ORDER BY SCINo DESC";
    $stmt1 = sqlsrv_query($conn2,$sql1);
    while($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
      $mainSCI = $row1['mainSCI'];
      if ($mainSCI == null || $mainSCI == "") {
        $TEMP_mainSCI = "SCI-".$section."-0001";
      }
      else{
        $tempVar = substr($mainSCI, 0,-4);
        $tempSCI= substr($mainSCI, -4);
        $a=$tempSCI;
        $b="1";
        $l=max(strlen($a),strlen($b));
        $finalNo=str_pad($a+$b, $l,"0", STR_PAD_LEFT);
        $stand = $finalNo;
        $TEMP_mainSCI = $tempVar.$stand;
      }
    
    $final_mainSCI = $TEMP_mainSCI;
    

    /*GET LAST SCI FROM REQUEST DATA*/
    $sql2 = "SELECT COUNT(SCINo) as requestSCI FROM SCI_Request WHERE SCINo = '$final_mainSCI'";
    $stmt2 = sqlsrv_query($conn2,$sql2);
    while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
      $requestSCI = $row2['requestSCI'];

      if ($requestSCI <= 1) {

       $tempVar = substr($requestSCI, 0,-4);
       $tempSCI= substr($requestSCI, -4);
       $a=$tempSCI;
       $b="1";
       $l=max(strlen($a),strlen($b));
       $finalNo=str_pad($a+$b, $l,"0", STR_PAD_LEFT);
       $stand = $finalNo;

       $final_NextSCI = $tempVar.$stand;
     }
     else{
      $final_NextSCI = $final_mainSCI;
    }
  }
}
    
  

?>
<!DOCTYPE html>
<html lang="en">

<style type="text/css">
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 20%;
  }

.prevent-select {
  -webkit-user-select: none; /* Safari */
  -ms-user-select: none; /* IE 10 and IE 11 */
  user-select: none; /* Standard syntax */
}

</style>
<?php include '../global/head.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<body>

 <?php include '../global/header.php'; ?>

  <?php include '../global/sidebar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Create Request <?php echo $row_count; ?></h1>
    </div>
    <section>
      <!-- Recent Sales -->
      <div class="col-lg-12">
        <div class="card recent-sales overflow-auto">
          <div class="card">
            <div class="card-body">

              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Create New</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Revision</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Abolition</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="borderedTabContent">
                <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">


             
            <div class="card-body">
         
              <!-- Floating Labels Form -->
              <form class="row g-3" name="create_new" id="create_new" method="POST" action="../process/mainProcess.php?function=create_new" enctype="multipart/form-data">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" name="requestDate" id="requestDate" value="<?php echo $today_noTime; ?>" readonly>
                    <label for="floatingName">Requested Date</label>
                  </div>
                </div>
                <?php
                $sql = "SELECT TOP(1) SCINo as NextSCI FROM SCI_Request WHERE RequestSection = '$section' ORDER BY SCINo DESC";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $stmt = sqlsrv_query( $conn2, $sql , $params, $options );

                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $NextSCI = $row['NextSCI'];
                }
                if ($NextSCI == null || $NextSCI == "") {
                  $final_NextSCI = "SCI-".$section."-0001";
                }
                else{
                  $tempVar = substr($NextSCI, 0,-4);
                  $tempSCI= substr($NextSCI, -4);
                  $a=$tempSCI;
                  $b="1";
                  $l=max(strlen($a),strlen($b));
                  $finalNo=str_pad($a+$b, $l,"0", STR_PAD_LEFT);
                  $stand = $finalNo;
                  $final_NextSCI = $tempVar.$stand;
                }

                ?>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="sciNo" class="form-control" id="sciNo" value="<?php echo $final_NextSCI; ?>" readonly title="<?php echo $final_NextSCI; ?>">
                    <label for="floatingEmail">Document / SCI Number <span style="color: red;">(Not Official)</span></label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="revNo" name="revNo" value="00" readonly title="Not yet Official">
                    <label for="floatingEmail">Revision Number</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control prevent-select" id="model" name="model" placeholder="Model" required>
                    <label for="model"><strong><i class="bi bi-check2" style="color:red"></i> Model</strong></label>
                  </div>
                </div>
                 <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="request_section" name="request_section" placeholder="Section" readonly value="<?php echo $section ?>">
                    <label for="section">Section</label>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="brow1" class="form-control prevent-select" id="select_spv" name="select_spv" placeholder="Select Supervisor" autocomplete="off" value="<?php echo $username ?>" > 
                      <label for="select_spv"><strong><i class="bi bi-check2" style="color:red"></i> Supervisor</strong></label>
                      <datalist id="brow1">
                       <?php
                       $sql = "SELECT DISTINCT FullName, BIPH_ID from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'SUPERVISOR' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'SUPERVISOR') ORDER BY FullName ASC ";
                       $stmt = sqlsrv_query($conn2,$sql);
                       while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $FullName = utf8_encode($row['FullName']);
                        echo '<option value="'.$row['FullName'].'">'.$BIPH_ID.'</option>';
                      }
                      ?>
                    </datalist> 
                  </div>
                </div>

               <div class="col-md-6">
                    <div class="form-floating">
                      <input type="search" list="brow2" class="form-control prevent-select" id="select_mgr" name="select_mgr" placeholder="Select Manager" autocomplete="off" value="<?php echo $username ?>" > 
                      <label class="prevent-select" for="select_mgr"><strong><i class="bi bi-check2" style="color:red"></i> Manager</strong></label>
                      <datalist id="brow2">
                       <?php
                       $sql = "SELECT DISTINCT FullName, BIPH_ID from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'MANAGER' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'MANAGER') ORDER BY FullName ASC";
                       $stmt = sqlsrv_query($conn2,$sql);
                       while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $FullName = utf8_encode($row['FullName']);
                        echo '<option value="'.$row['FullName'].'">'.$BIPH_ID.'</option>';
                      }
                      ?>
                    </datalist> 
                  </div>
                </div>

                 
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="validity" id="permanent" value="Permanent">
                      <label class="form-check-label prevent-select" for="permanent">
                        Permanent
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="validity" id="temporary" value="Temporary">
                      <label class="form-check-label prevent-select" for="temporary">
                        Temporary
                      </label>
                    </div>
                    <div class="row mb-3">
                      <label for="inputDate" class="col-sm-2 col-form-label prevent-select">Validity Date: </label>
                      <div class="col-sm-6">
                        <input type="date" class="form-control" name="validity_date" id="validity_date" readonly required>
                      </div>
                    </div>
                  </div>

                 <div class="col-md-6">
                  <label for="inputNumber" class="col-sm-6 col-form-label prevent-select"><strong><i class="bi bi-check2" style="color:red"></i> SCI Attachment</strong></label>
                  <div class="col-12">
                    <input class="form-control" type="file" id="file" name="file" onchange="verifyExcel()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                  </div>
                </div>


                 <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control prevent-select" placeholder="Request Details" name="details" id="details" style="height: 100px;"></textarea>
                    <label for="details"><strong><i class="bi bi-check2" style="color:red"></i> Request Details</strong></label>
                  </div>
                </div>

                <div class="text-center">
                  <br>
                  <br>
                  <button type="reset" class="btn btn-lg btn-danger">Reset Inputs</button>
                  <button type="button" onclick="confirm_new()" class="btn btn-lg btn-success">Create Request</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>




                </div>
                <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                  Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
                </div>
                <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
                  Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

    </div>
  </div><!-- End Recent Sales -->
</section>


<section>
  <div class="modal fade" id="declineRequest" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="declineRequest1"></div>

     </div>
   </div>
 </div>
</section>

<section>
  <div class="modal fade" id="viewDetails" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
       <div class="viewDetails1"></div>

     </div>
   </div>
 </div>
</section>


<?php

include '../modal/newAccount.php';

?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>

 <script type="text/javascript">

  function doValidate() {
    var val = $("#select_spv").val();

    var obj = $("#brow1").find("option[value='" + val + "']");


    if (obj.length > 0) {

    }
    else{
      alert(obj.length);
    }

 

}




function confirm_new() {

  var model = $('#model').val();
  var select_spv = $('#select_spv').val();
  var select_mgr = $('#select_mgr').val();
  var details = $('#details').val();
  var validity_date = $('#validity_date').val();

    if (model == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Model", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#model').focus();
    }

  else if (select_spv == "")
    {
      setTimeout(function() {
        swal({
          text: 'Selection required!',
          title: "Supervisor", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#select_spv').focus();
    }
    else if (select_mgr == "")
    {
      setTimeout(function() {
        swal({
          text: 'Selection required!',
          title: "Manager", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#select_mgr').focus();
    }

    else if($('.form-check-input:checked').length < 1) {
      this.checked = false;
      setTimeout(function() {
        swal({
          text: 'Please select Request Validity.',
          title: "Select Validity", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#permanent').focus();
    }

    else if (document.getElementById('validity_date').readOnly == false) {
    setTimeout(function() {
        swal({
          text: 'Please input Validity Date.',
          title: "Select Validity", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#validity_date').focus();
    }

    else if (document.getElementById('file').files.length == 0)
    {
      setTimeout(function() {
        swal({
          text: 'Attachment required!',
          title: "SCI Attachment", 
          type: "warning",   
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#file').focus();
    }
    else if (details == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Details", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#details').focus();
    }
    
    else{

       setTimeout(function() {
        swal({
          title: 'Create New Request',
          text: 'Are you sure you want to proceed ?',
          imageUrl: '../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: 'green',
          confirmButtonText: 'Yes, proceed it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'red',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
          
            document.getElementById("btnLoading").click();
             document.getElementById("create_new").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }



  $('input[id="temporary"]').change(function(){
    if($(this).is(':checked')){

      $(this).attr('readOnly',false);
      document.getElementById('validity_date').readOnly = false;
      document.getElementById('validity_date').focus();
      document.getElementById('validity_date').value = null;

    }
    else{
      document.getElementById('validity_date').readOnly = true;
    }
  });



  $('input[id="permanent"]').change(function(){
    if($(this).is(':checked')){

    
      document.getElementById('validity_date').readOnly = true;
      document.getElementById('validity_date').value = null;

    }
    else{
      document.getElementById('validity_date').readOnly = false;
    }
  });


function verifyExcel() {
  var fileName = document.getElementById('file').value.toLowerCase();
  if(!fileName.endsWith('.xlsx') && !fileName.endsWith('.xls')){
    alert('Please upload excel file only.');
   document.getElementById('file').value = null;
    return false;
  }
}

</script>

</body>

</html>