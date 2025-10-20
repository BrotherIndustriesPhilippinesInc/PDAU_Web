<?php
include '../global/conn.php';
session_start();
$title = 'reApply';
$page = 'sci';

$requestID = $_GET['requestID'];
$dataID = $_GET['dataID'];

if ($requestID == null || $requestID == "") {
 header('Location:ongoingRequest.php');
}


$sql = "SELECT * FROM SCI_Request WHERE RequestID = '$requestID'";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn2, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $stmt );

if ($row_count <= 0) {
  ?>
  <script type="text/javascript">
    alert('<?php echo $requestID ?> is not valid. Please check your inputs and try again.');
    window.location.replace('ongoingRequest.php');
  </script>
  <?php
}
else{
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
   $Status = $row['Status'];
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
   $SCIExcel = $row['SCIExcel'];
 }
}


$sql2 = "SELECT * FROM SCI_Approval WHERE RequestID = '$requestID'";
$stmt2 = sqlsrv_query($conn2,$sql2);
while($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
  $SPV = $row2['SPV'];
  $spvStatus = $row2['SPV_status'];
  $spvDate = $row2['SPV_date'];
  $spvRemarks = $row2['SPV_remarks'];

  $MGR = $row2['MGR'];
  $mgrStatus = $row2['MGR_status'];
  $mgrDate = $row2['MGR_date'];
  $mgrRemarks = $row2['MGR_remarks'];
  $RejectedAt = $row2['RejectedAt'];
}

if ($RejectedAt == 'SUPERVISOR') {
 $final_name = $SPV;
 $final_status = $spvStatus;
 $final_date = $spvDate;
 $final_remarks = $spvRemarks;
}
else{
 $final_name = $MGR;
 $final_status = $mgrStatus;
 $final_date = $mgrDate;
 $final_remarks = $mgrRemarks;
}



if ($Status!='DECLINED') {
  ?>
  <script type="text/javascript">
    alert('<?php echo $requestID ?> is not available for Re-Apply.');
    window.location.replace('ongoingRequest.php');
  </script>
  <?php
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

<body>

 <?php include '../global/header.php'; ?>

  <?php include '../global/sidebar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1 id="mainHeader" class="prevent-select">Re-Apply Request [ <?php echo $requestID; ?> ] </h1>
     <!--  <input type="text" id="mainHeader" name="mainHeader"> -->
    </div>
    <section>
      <!-- Recent Sales -->
      <div class="col-lg-12">
        <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <?php
                  if ($RequestType =='NEW') {
                    ?>
                    <button class="nav-link active prevent-select" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true" title="Create New Request">Create New SCI</button>
                    <?php
                  }
                  else{
                    ?>
                    <button class="nav-link prevent-select" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true" disabled title="Create New Request">Create New SCI</button>
                    <?php
                  }
                  ?>
                </li>

                <li class="nav-item" role="presentation">
                  <?php
                  if ($RequestType == 'REVISION') {
                    ?>
                     <button class="nav-link active prevent-select" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="true" title="Create Revision Request">SCI Revision</button>

                    <?php
                  }
                  else{
                    ?>
                     <button class="nav-link  prevent-select" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" disabled aria-selected="true" title="Create Revision Request">SCI Revision</button>
                    <?php
                  }
                  ?>
                </li>

                <li class="nav-item" role="presentation">
                  <?php
                  if ($RequestType == 'ABOLITION') {
                    ?>
                    <button class="nav-link active prevent-select" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false" title="Create Abolition Request">SCI Abolition</button>
                    <?php
                  }
                  else{
                    ?>
                    <button class="nav-link prevent-select" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" disabled aria-selected="false" title="Create Abolition Request">SCI Abolition</button>
                    <?php
                  }
                  ?>
                </li>

                <li class="nav-item">
                  <a class="prevent-select" style="color:#009;font-weight: 700; margin-top: 8px;" id="download-tab" type="button" aria-selected="false" title="Download Template" href="http://apbiphsh07/portal/99_Common/PE/New%20Application%20Forms/00_PE%20Common/REC0801-110-01_Special%20Check%20Items.xlsx">Download Template</a>

                  <!-- <a class="prevent-select" style="color:#009;font-weight: 700; margin-top: 8px;" id="download-tab" type="button" aria-selected="false" title="Download Template" href="http://apbiphsh07/portal/99_Common/PE/New%20Application%20Forms/00_PE%20Common/Special%20Check%20Item.xlsx">Download Template</a>
 -->
                  
                </li>
              </ul>


              <br>
           <table class="table table-bordered">
             <tr>
              <th>Declined By</th>
               <th>Date</th>
               <th>Name</th>
               <th>Judgement</th>
               <th>Reasons</th>
             </tr>
             <tr>
              <td><?php echo $RejectedAt; ?></td>
               <td><?php echo $final_date; ?></td>
               <td><?php echo $final_name; ?></td>
               <td style="color: red"><b><?php echo $final_status; ?></b></td>
               <td><?php echo $final_remarks; ?></td>

             </tr>
           </table>

                 <div class="tab-content pt-2" id="borderedTabContent">
                  <?php
                  if ($RequestType == 'NEW') {
                    echo '<div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">';
                    include 'reapplyNew.php';
                    echo '</div>';
                  }
                  elseif ($RequestType == 'REVISION') {
                    echo '<div class="tab-pane fade show active" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">';
                    include 'reapplyRev.php';
                    echo '</div>';
                  }
                  elseif ($RequestType == 'ABOLITION') {
                    echo '<div class="tab-pane fade show active" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">';
                    include 'reapplyAbolition.php';
                    echo '</div>';
                  }
                  ?>
                </div><!-- End Bordered Tabs -->

            </div>

    </div>
  </div><!-- End Recent Sales -->
</section>




<datalist id="browModel">
 <?php
 $sql = "SELECT DISTINCT Model from SCI_MainData WHERE Section = '$section' ORDER BY Model ASC";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $Model = utf8_encode($row['Model']);
  echo '<option>'.$Model.'</option>';
}
?>
</datalist>
<datalist id="browSPV">
 <?php
 $sql = "SELECT DISTINCT FullName, BIPH_ID from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'SUPERVISOR' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'SUPERVISOR') ORDER BY FullName ASC ";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $FullName = utf8_encode($row['FullName']);
  echo '<option value="'.$row['FullName'].'">'.$BIPH_ID.'</option>';
}
?>
</datalist>
<datalist id="browMGR">
 <?php
 $sql = "SELECT DISTINCT FullName, BIPH_ID from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'MANAGER' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'MANAGER') ORDER BY FullName ASC";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $FullName = utf8_encode($row['FullName']);
  echo '<option value="'.$row['FullName'].'">'.$BIPH_ID.'</option>';
}
?>
</datalist>
<datalist id="browSCI">
 <?php
 $sql = "SELECT DISTINCT SCINo from SCI_MainData WHERE Section = '$section' AND Status='Active' ORDER BY SCINo ASC";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $SCINo = utf8_encode($row['SCINo']);
  echo '<option>'.$SCINo.'</option>';
}
?>
</datalist>



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>

 <script type="text/javascript">


function confirm_new() {

  var model = $('#model').val();
  var select_spv = $('#select_spv').val();
  var select_mgr = $('#select_mgr').val();
  var details = $('#details').val();
  var validity_date = $('#validity_date').val();
  var title = $('#title').val();

   
     if (title == "")
    {
      setTimeout(function() {
        swal({
          text: 'Input required!',
          title: "Title", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#title').focus();
    }
    else if (model == "")
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

    else if (!document.getElementById('validity_date').value) {
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
          title: 'Re-apply New Request',
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
             document.getElementById("reapply_new").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }

  function cancelReApply(){

    setTimeout(function() {
        swal({
          title: 'Cancel Re-application',
          text: 'Are you sure you want to cancel your Re-application?',
          imageUrl: '../assets/img/question-red.png',
          showCancelButton: true,
          confirmButtonColor: '#d10e00',
          confirmButtonText: 'Yes, cancel it!',
          cancelButtonText: 'Cancel',
          cancelButtonColor: 'blue',
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
          
          window.location.replace("ongoingRequest");
          
          } else {
            
          }
        });
      }, 100);
  }


/*
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
  });*/




  $('input[id="temporary"]').change(function(){
    if($(this).is(':checked')){

      $(this).attr('readOnly',false);
      document.getElementById('validity_date').readOnly = false;
      document.getElementById('validity_date').focus();
      document.getElementById('validity_date').type = 'date';
      document.getElementById('validity_date').value = null;

    }
   
  });


  $('input[id="permanent"]').change(function(){
    if($(this).is(':checked')){
    
      document.getElementById('validity_date').readOnly = true;
      document.getElementById('validity_date').type = 'text';
      document.getElementById('validity_date').value = "-";

    }
   
  });


function verifyExcel() {
  var fileName = document.getElementById('file').value.toLowerCase();
  if(!fileName.endsWith('.xlsx') && !fileName.endsWith('.xls')){
    /*alert('Please upload excel file only.');*/
     setTimeout(function() {
      swal({
        text: 'Please upload Excel (xlsx or xls) file only.',
        title: "Attachment Denied", 
        type: "warning",
        showConfirmButton: true,
        confirmButtonText: "OK",   
        closeOnConfirm: true 
      }, function(){
      });
    }, 100);
   document.getElementById('file').value = null;
    return false;
  }
}

function verifyExcelRev() {
  var fileName = document.getElementById('file_rev').value.toLowerCase();
  if(!fileName.endsWith('.xlsx') && !fileName.endsWith('.xls')){
   /* alert('Please upload excel file only.');*/
    setTimeout(function() {
      swal({
        text: 'Please upload Excel (xlsx or xls) file only.',
        title: "Attachment Denied", 
        type: "warning",
        showConfirmButton: true,
        confirmButtonText: "OK",   
        closeOnConfirm: true 
      }, function(){
      });
    }, 100);
   document.getElementById('file_rev').value = null;
    return false;
  }
}


  $('input[id="temporary_rev"]').change(function(){
    if($(this).is(':checked')){

      $(this).attr('readOnly',false);
      document.getElementById('validity_date_rev').readOnly = false;
      document.getElementById('validity_date_rev').focus();
      document.getElementById('validity_date_rev').type = 'date';
      document.getElementById('validity_date_rev').value = null;

    }
   
  });


  $('input[id="permanent_rev"]').change(function(){
    if($(this).is(':checked')){
    
      document.getElementById('validity_date_rev').readOnly = true;
      document.getElementById('validity_date_rev').type = 'text';
      document.getElementById('validity_date_rev').value = "-";

    }
   
  });

function checkSCI_rev() {

  $(document).ready(function(){ 

   var revNo_rev= document.getElementById('revNo_rev');
   var title_rev = document.getElementById('title_rev');
   var model_rev = document.getElementById('model_rev');
   var validity_check = document.getElementById('validity_check');
   var sciNo_rev = $('#sciNo_rev').val();
   var section_rev = "<?php echo $section; ?>";

   if (sciNo_rev == null || sciNo_rev == "") {
    document.reapply_rev.sciNo_rev.focus();
    document.reapply_rev.sciNo_rev.value = "";
    revNo_rev.value="00";
    title_rev.value="";
    model_rev.value="";
    document.getElementById('permanent_rev').checked = false;
    document.getElementById('temporary_rev').checked = false;
    document.getElementById('validity_date_rev').value = null;
    document.getElementById('validity_date_rev').readOnly = true;
  }
  else{

    $.ajax({
      url:"../process/ajax_checkSCI.php",
      method:"POST",
      data:{sciNo_rev:sciNo_rev, section_rev:section_rev},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("SCI Document Number is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please check your inputs and try again.',
              title: "SCI Document Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_rev.sciNo_rev.focus();
          document.reapply_rev.sciNo_rev.value = "";
          revNo_rev.value="00";
          title_rev.value="";
          model_rev.value="";
          validity_check.value="";
        }
      
        else{
          $('#revNo_rev').val(data.revNo_rev);
          $('#title_rev').val(data.title_rev);
          $('#model_rev').val(data.model_rev);
        
          if (data.validity_check == 'Permanent') {
           document.getElementById('permanent_rev').checked = true;
           document.getElementById('temporary_rev').checked = false;
           document.getElementById('validity_date_rev').readOnly = true;
           document.getElementById('validity_date_rev').value = null;
          }
          else{
           document.getElementById('permanent_rev').checked = false;
           document.getElementById('temporary_rev').checked = true;
           document.getElementById('validity_date_rev').readOnly = false;
           $('#validity_date_rev').val(data.validity_date);
          }
        }
      }
    });
  }

});

}



function confirm_rev() {

  var model_rev = $('#model_rev').val();
  var select_spv_rev = $('#select_spv_rev').val();
  var select_mgr_rev = $('#select_mgr_rev').val();
  var details_rev = $('#details_rev').val();
  var validity_date_rev = $('#validity_date_rev').val();
  var title_rev = $('#title_rev').val();
  var sciNo_rev = $('#sciNo_rev').val();


  if (sciNo_rev == "")
  {
    setTimeout(function() {
      swal({
        text: 'Input required!',
        title: "SCI Document", 
        type: "warning",
        showConfirmButton: true,
        confirmButtonText: "OK",   
        closeOnConfirm: true 
      }, function(){
      });
    }, 100);
    $('#sciNo_rev').focus();
  }

  else if (select_spv_rev == "")
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
      $('#select_spv_rev').focus();
    }
    else if (select_mgr_rev == "")
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
      $('#select_mgr_rev').focus();
    }

    else if (!document.getElementById('validity_date_rev').value) {
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
      $('#validity_date_rev').focus();
    }

    else if (document.getElementById('file_rev').files.length == 0)
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
      $('#file_rev').focus();
    }
    else if (details_rev == "")
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
      $('#details_rev').focus();
    }
    
    else{

       setTimeout(function() {
        swal({
          title: 'Re-apply Revision Request',
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
             document.getElementById("reapply_rev").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }


  function checkSCI_abo() {

  $(document).ready(function(){ 

   var revNo_abo= document.getElementById('revNo_abo');
   var title_abo = document.getElementById('title_abo');
   var model_abo = document.getElementById('model_abo');
   var validity_abo = document.getElementById('validity_abo');
   var validity_date_abo = document.getElementById('validity_date_abo');
   var sciFile = document.getElementById('sciFile');
   var section_abo = "<?php echo $section; ?>";

   var sciNo_abo = $('#sciNo_abo').val();

   if (sciNo_abo == null || sciNo_abo == "") {
    document.reapply_abo.sciNo_abo.focus();
    document.reapply_abo.sciNo_abo.value = "";
    revNo_abo.value="00";
    title_abo.value="";
    model_abo.value="";
    validity_abo.value="";
    validity_date_abo.value="";
    sciFile.value="";
    document.getElementById('btnSCIFile').disabled = true;

  }
  else{

    $.ajax({
      url:"../process/ajax_checkAboSCI.php",
      method:"POST",
      data:{sciNo_abo:sciNo_abo, section_abo:section_abo},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
         /* alert("SCI Document Number is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please check your inputs and try again.',
              title: "SCI Document Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_abo.sciNo_abo.focus();
          document.reapply_abo.sciNo_abo.value = "";
          revNo_abo.value="00";
          title_abo.value="";
          model_abo.value="";
          validity_abo.value="";
          validity_date_abo.value="";
          sciFile.value="";
          document.getElementById('btnSCIFile').disabled = true;
        }

        else if (data.count == 2) {
         setTimeout(function() {
          swal({
            text: 'SCI Document have existing request. Please complete or cancel the previous request.',
            title: "Request Failed", 
            type: "warning",
            showConfirmButton: true,
            confirmButtonText: "OK",   
            closeOnConfirm: true 
          }, function(){
          });
        }, 100);
         document.reapply_abo.sciNo_abo.focus();
         document.reapply_abo.sciNo_abo.value = "";
         revNo_abo.value="00";
         title_abo.value="";
         model_abo.value="";
         validity_abo.value="";
         validity_date_abo.value="";
         sciFile.value="";
         document.getElementById('btnSCIFile').disabled = true;
        }
      
        else{
          $('#revNo_abo').val(data.revNo_abo);
          $('#title_abo').val(data.title_abo);
          $('#model_abo').val(data.model_abo);
          $('#validity_abo').val(data.validity_abo);
          $('#validity_date_abo').val(data.validity_date_abo);
          $('#sciFile').val(data.sciFile);
         document.getElementById('btnSCIFile').disabled = false;
        }
      }
    });
  }

});

}


function confirm_abo() {

  var details_abo = $('#details_abo').val();
  var sciNo_abo = $('#sciNo_abo').val();
  var select_spv_abo= $('#select_spv_abo').val();
  var select_mgr_abo = $('#select_mgr_abo').val();

   
  if (sciNo_abo == "")
  {
    setTimeout(function() {
      swal({
        text: 'Input required!',
        title: "SCI Document Number", 
        type: "warning",
        showConfirmButton: true,
        confirmButtonText: "OK",   
        closeOnConfirm: true 
      }, function(){
      });
    }, 100);
    $('#sciNo_abo').focus();
  }

 else if (select_spv_abo == "")
    {
      setTimeout(function() {
        swal({
          text: 'Selection required!',
          title: "Select Supervisor", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#select_spv_abo').focus();
    }
    else if (select_mgr_abo == "")
    {
      setTimeout(function() {
        swal({
          text: 'Selection required!',
          title: "Select Manager", 
          type: "warning",
          showConfirmButton: true,
          confirmButtonText: "OK",   
          closeOnConfirm: true 
        }, function(){
        });
      }, 100);
      $('#select_mgr_abo').focus();
    }

    else if (details_abo == "")
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
      $('#details_abo').focus();
    }
    
    else{

       setTimeout(function() {
        swal({
          title: 'Create Abolition Request',
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
             document.getElementById("reapply_abo").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }


function openFile() {
 var sciNo_abo = $('#sciNo_abo').val();
 var sciFile = $('#sciFile').val();

if (sciFile != null || sciFile != "") {
  window.open("../SCI/MainData/"+sciNo_abo+"/"+sciFile);
}

}

function checkSPV_new() {

  $(document).ready(function(){ 

   var select_spv = $('#select_spv').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_spv == null || select_spv == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkSPV.php",
      method:"POST",
      data:{spv:select_spv, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("Supervisor is not valid. Please check your inputs and try again.");*/
           setTimeout(function() {
            swal({
              text: 'Please select Authorized Supervisor.',
              title: "Supervisor Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_new.select_spv.focus();
          document.reapply_new.select_spv.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}

function checkSPV_rev() {

  $(document).ready(function(){ 

   var select_spv_rev = $('#select_spv_rev').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_spv_rev == null || select_spv_rev == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkSPV.php",
      method:"POST",
      data:{spv:select_spv_rev, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
         /* alert("Supervisor is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please select Authorized Supervisor.',
              title: "Supervisor Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_rev.select_spv_rev.focus();
          document.reapply_rev.select_spv_rev.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}

function checkSPV_abo() {

  $(document).ready(function(){ 

   var select_spv_abo = $('#select_spv_abo').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_spv_abo == null || select_spv_abo == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkSPV.php",
      method:"POST",
      data:{spv:select_spv_abo, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
         /* alert("Supervisor is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please select Authorized Supervisor.',
              title: "Supervisor Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_abo.select_spv_abo.focus();
          document.reapply_abo.select_spv_abo.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}


function checkMGR_new() {

  $(document).ready(function(){ 

   var select_mgr = $('#select_mgr').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_mgr == null || select_mgr == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkMGR.php",
      method:"POST",
      data:{mgr:select_mgr, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("Manager is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please select Authorized Manager.',
              title: "Manager Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_new.select_mgr.focus();
          document.reapply_new.select_mgr.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}

function checkMGR_rev() {

  $(document).ready(function(){ 

   var select_mgr_rev = $('#select_mgr_rev').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_mgr_rev == null || select_mgr_rev == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkMGR.php",
      method:"POST",
      data:{mgr:select_mgr_rev, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("Manager is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please select Authorized Manager.',
              title: "Manager Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_rev.select_mgr_rev.focus();
          document.reapply_rev.select_mgr_rev.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}

function checkMGR_abo() {

  $(document).ready(function(){ 

   var select_mgr_abo = $('#select_mgr_abo').val();
   var checkSection = "<?php echo $section; ?>";

   if (select_mgr_abo == null || select_mgr_abo == "") {
    
   }
  else{

    $.ajax({
      url:"../process/ajax_checkMGR.php",
      method:"POST",
      data:{mgr:select_mgr_abo, section:checkSection},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("Manager is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please select Authorized Manager.',
              title: "Manager Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.reapply_abo.select_mgr_abo.focus();
          document.reapply_abo.select_mgr_abo.value = "";
        }
      
        else{
      
        }
      }
    });
  }

});

}
</script>

</body>

</html>