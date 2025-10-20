<?php
include '../global/conn.php';
session_start();
$title = 'sciRequest';
$page = 'sci';

  

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

 <?php include_once '../global/session_validator.php';?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1 id="mainHeader" class="prevent-select">Create New SCI</h1>
    <!--   <a href="../assets/Special_Check_Item.xlsx">Download Template</a> -->
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
                  <button class="nav-link active prevent-select" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true" title="Create New Request" onclick="mainHeader.innerText = 'Create New SCI'">Create New SCI</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link prevent-select" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" title="Create Revision Request" onclick="mainHeader.innerText = 'SCI Revision'">SCI Revision</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link prevent-select" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false" title="Create Abolition Request" onclick="mainHeader.innerText = 'SCI Abolition'">SCI Abolition</button>
                </li>
                <li class="nav-item">
                  <!-- <a class="prevent-select" style="color:#009;font-weight: 700; margin-top: 8px;" id="download-tab" type="button" aria-selected="false" title="Download Template" href="../SCI/Special_Check_Item.xlsx">Download Template</a> -->
                  <a class="prevent-select" style="color:#009;font-weight: 700; margin-top: 8px;" id="download-tab" type="button" aria-selected="false" title="Download Template" href="http://apbiphsh07/portal/99_Common/PE/New%20Application%20Forms/00_PE%20Common/REC0801-110-01_Special%20Check%20Items.xlsx">Download Template</a>
                </li>
              </ul>
              <div class="tab-content pt-2" id="borderedTabContent">


          <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
           <?php include 'createReqNew.php'; ?>
          </div>


          <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
           <?php include 'createReqRev.php'; ?>
          </div>


          <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
            <?php include 'createAbolition.php'; ?>

          </div>
        </div><!-- End Bordered Tabs -->

            </div>

    </div>
  </div><!-- End Recent Sales -->
</section>

<datalist id="browSPV">
 <?php
 $sql = "SELECT DISTINCT FullName, Department, Section from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'SUPERVISOR' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'SUPERVISOR') AND AccountStatus = 'Active' ORDER BY FullName ASC ";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $FullName = utf8_encode($row['FullName']);
  $spvDept = $row['Department'];
  $spvSection = $row['Section'];
  echo '<option value="'.$row['FullName'].'">'.$spvDept.' - '.$spvSection.'</option>';
}
?>
</datalist> 

<datalist id="browMGR">
 <?php
 $sql = "SELECT DISTINCT FullName, Department, Section from Accounts WHERE Section = '$section' AND SystemNo = 2 AND AccountType = 'MANAGER' OR BIPH_ID in (select  BIPH_ID from AdditionalSection WHERE Section = '$section' AND AccountType = 'MANAGER') ORDER BY FullName ASC";
 $stmt = sqlsrv_query($conn2,$sql);
 while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $FullName = utf8_encode($row['FullName']);
  $mgrDept = $row['Department'];
  $mgrSection = $row['Section'];
  echo '<option value="'.$row['FullName'].'">'.$mgrDept.' - '.$mgrSection.'</option>';
}
?>
</datalist> 

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
      document.create_rev.sciNo_rev.focus();
      document.create_rev.sciNo_rev.value = "";
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
          document.create_rev.sciNo_rev.focus();
          document.create_rev.sciNo_rev.value = "";
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
           document.getElementById('validity_date_rev').value = "-";
          }
          else{
           document.getElementById('permanent_rev').checked = false;
           document.getElementById('temporary_rev').checked = true;
           document.getElementById('validity_date_rev').readOnly = false;
           document.getElementById('validity_date_rev').type = 'date';
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

    /*else if (document.getElementById('temporary_rev').checked == true && document.getElementById('validity_date_rev').value == null) {
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
    }*/

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
          title: 'Create Revision Request',
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
             document.getElementById("create_rev").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }


  function checkSCIAbo() {

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
    document.create_abo.sciNo_abo.focus();
    document.create_abo.sciNo_abo.value = "";
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
          /*alert("SCI Document Number is not valid. Please check your inputs and try again.");*/
          document.create_abo.sciNo_abo.focus();
          document.create_abo.sciNo_abo.value = "";
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
         /*alert("SCI Document Number is not valid. Please check your inputs and try again.");*/
         document.create_abo.sciNo_abo.focus();
         document.create_abo.sciNo_abo.value = "";
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
             document.getElementById("create_abo").submit();
          } else {
            
          }
        });
      }, 100);

    }

  }


function openFile() {
 var sciNo_abo = $('#sciNo_abo').val();
 var sciFile = $('#sciFile').val();
 var section = "<?php echo $section ?>";

if (sciFile != null || sciFile != "") {
  window.open("../SCI/"+section+"/MainData/"+sciNo_abo+"/"+sciFile);
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
          document.create_new.select_spv.focus();
          document.create_new.select_spv.value = "";
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
          document.create_rev.select_spv_rev.focus();
          document.create_rev.select_spv_rev.value = "";
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
          document.create_abo.select_spv_abo.focus();
          document.create_abo.select_spv_abo.value = "";
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
          document.create_new.select_mgr.focus();
          document.create_new.select_mgr.value = "";
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
          document.create_rev.select_mgr_rev.focus();
          document.create_rev.select_mgr_rev.value = "";
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
          document.create_abo.select_mgr_abo.focus();
          document.create_abo.select_mgr_abo.value = "";
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