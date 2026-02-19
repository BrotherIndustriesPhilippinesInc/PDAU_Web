<?php

session_start();
if ($_SESSION['pdau_id'] == null || $_SESSION['pdau_id'] == "") {
  header('../index.php');
}
$title = 'sci_maindata';


include '../global/conn.php';
include '../global/userInfo.php';


$sciNo = $_GET['sciNo'];

//Get additional section of user
$user_login = $_SESSION['pdau_id'];
// Get all additional sections
$additionalSection = [];
$sqlAdditional = "SELECT Section FROM AdditionalSection WHERE BIPH_ID = ?";
$paramsAdditional = [$user_login];
$stmtAdditional = sqlsrv_query($conn2, $sqlAdditional, $paramsAdditional);

if ($stmtAdditional === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmtAdditional, SQLSRV_FETCH_ASSOC)) {
    $additionalSection[] = $row['Section'];
}

// Get SCI data
$sql = "SELECT Section, SCIFile, RevNo FROM SCI_MainData WHERE SCINo = ?";
$params = [$sciNo];
$stmt = sqlsrv_query($conn2, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$sci_section = $row['Section'];
$sci_file = $row['SCIFile'];
$revNo = $row['RevNo'];

// ✅ Access check
$hasAccess = false;
// 1. If user’s main section matches
if ($section === $sci_section) {
    $hasAccess = true;
}
// 2. Or if user has it in additional sections.
elseif (in_array($sci_section, $additionalSection)) {
    $hasAccess = true;
}
// 3. Or if section is 'Common'
elseif ($section === 'Common') {
    $hasAccess = true;
}
if (!$hasAccess) {
    ?>
    <script type="text/javascript">
      alert('Access Denied!');
      // window.location.replace('../index.php');
    </script>
    <?php
}


$fileType = pathinfo($sci_file, PATHINFO_EXTENSION);

?>
<!DOCTYPE html>
<html lang="en">

<?php include '../global/head.php'; ?>
<link href="../assets/css/photoviewer.css" rel="stylesheet">


<style>
    .photoviewer-modal {
      background-color: transparent;
      border: none;
      border-radius: 0;
      box-shadow: 0 0 6px 2px rgba(0, 0, 0, .3);

    }

    .photoviewer-header .photoviewer-toolbar {
      background-color: rgba(0, 0, 0, .5);
    }

    .photoviewer-stage {
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: rgba(0, 0, 0, .85);
      border: none;
    }

    .photoviewer-footer .photoviewer-toolbar {
      background-color: rgba(0, 0, 0, .5);
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    .photoviewer-header,
    .photoviewer-footer {
      border-radius: 0;
      pointer-events: none;
    }

    .photoviewer-title {
      color: #ccc;
    }

    .photoviewer-button {
      color: #ccc;
      pointer-events: auto;
    }

    .photoviewer-header .photoviewer-button:hover,
    .photoviewer-footer .photoviewer-button:hover {
      color: white;
    }
  </style>

<?php if ($fileType == 'pdf' || $fileType == 'PDF'): ?>
  <body>
  <?php else : ?>
      <body dir="ltr" onload="viewImg();">
<?php endif ?>
  <main>
    <div class="container" >

      <div class="image-set">
        <a id="gallery" data-gallery="photoviewer" data-title="<?php echo $sciNo; ?>" data-group="a"
          href="../SCI/<?php echo $sci_section;?>/MainData/<?php echo $sciNo.'/'.$sci_file; ?>">
        </a>
      </div>

      <section class="section error-404 min-vh-200 d-flex flex-column align-items-center justify-content-center">
          <form name="viewSCI" id="viewSCI">
          <div class="input-group mb-2">
            <input type="search" list="brow2" class="form-control" placeholder="SCI No" aria-label="SCI No" style="width:250px; font-size: 25px;text-align: center;" value="<?php echo $sciNo; ?>" name="sciNo" id="sciNo" required oninput="this.value = this.value.toUpperCase();" onchange="checkAbolitionSCI();" autofocus onfocus="let value = this.value; this.value = null; this.value=value" >
            <datalist id="brow2">
             <?php
             if ($section == 'Common') {
                $sql = "SELECT SCINo, Title from SCI_MainData WHERE Status = 'Active' ORDER BY SCINo ASC";
             }
             else{
               $sql = "SELECT SCINo, Title from SCI_MainData WHERE Section = '$sci_section' AND Status = 'Active' ORDER BY SCINo ASC";
             }
            
             $stmt = sqlsrv_query($conn2,$sql);
             while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              echo '<option value="'.$row['SCINo'].'">'.$row['Title'].'</option>';
            }
            ?>
            </datalist>
            <span class="input-group-text" >-</span>
            <input type="text" class="form-control" id="revNo" name="revNo" placeholder="Revision No" aria-label="Revision No" style="width:200px; font-size: 25px;text-align: center;" readonly value="<?php echo $revNo ?>">
          </div>
          <!-- <input type="text" class="form-control" id="revNo" name="revNo" placeholder="Revision No" aria-label="Revision No" style="width:200px; font-size: 25px;text-align: center;" readonly value="<?php echo $revNo ?>"> -->
          <input type="text" name="sci_section" id="sci_section" value="<?php echo $sci_section; ?>" hidden>
          </form>
        <?php
        if ($fileType == 'pdf' || $fileType == 'PDF') {
          ?>
          <a target="_blank" class="btn btn-sm btn-success" href="../SCI/<?php echo $sci_section;?>/MainData/<?php echo $sciNo.'/'.$sci_file; ?>#page=1&zoom=90">Click Here to view fullscreen</a>
          <iframe src="../SCI/<?php echo $sci_section;?>/MainData/<?php echo $sciNo.'/'.$sci_file; ?>#page=1&zoom=90" style="width:1500px;height: 800px;"></iframe>
          <?php
        }
        else{
          ?>
          <button class="btn btn-sm btn-success" onclick="viewImg();">Click Here to Reload</button>
          <?php
        }
        ?>
          
          <br>
        <div class="credits">
         &copy; 2022 <strong><span>Process Document Auto Updater</span></strong>
        </div>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <?php include '../global/scripts.php'; ?>


  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../assets/js/photoviewer.js"></script>

  <script type="text/javascript">
    function checkAbolitionSCI() {

  $(document).ready(function(){ 

   var revNo= document.getElementById('revNo');
   var sciNo = $('#sciNo').val();
   var sci_section = $('#sci_section').val();
   var user_section = "<?php echo $section; ?>";

   if (sciNo == null || sciNo == "") {
    document.viewSCI.sciNo.focus();
    document.viewSCI.sciNo.value = "<?php echo $sciNo; ?>";
    revNo.value="<?php echo $revNo; ?>";
    /*document.getElementById('btnSCIGo').disabled = true;*/

  }
  else{

    $.ajax({
      url:"../process/ajax_checkViewSCI.php",
      method:"POST",
      data:{sciNo:sciNo,sci_section:sci_section,user_section:user_section},
      dataType:"JSON",
      success:function(data)
      {
        if (data.count == 0) {
          /*alert("SCI Document Number is not valid. Please check your inputs and try again.");*/
          setTimeout(function() {
            swal({
              text: 'Please check your inputs and try again',
              title: "SCI Document Not Valid", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.viewSCI.sciNo.focus();
          document.viewSCI.sciNo.value = "<?php echo $sciNo; ?>";
          revNo.value="<?php echo $revNo; ?>";
        }
        else if (data.count == 99) {
          /*alert("SCI Document Number is not Authorized to your section.");*/
          setTimeout(function() {
            swal({
              text: 'Please select the Authorized SCI Document to your section.',
              title: "Access Denied", 
              type: "warning",
              showConfirmButton: true,
              confirmButtonText: "OK",   
              closeOnConfirm: true 
            }, function(){
            });
          }, 100);
          document.viewSCI.sciNo.focus();
          document.viewSCI.sciNo.value = "<?php echo $sciNo; ?>";
          revNo.value="<?php echo $revNo; ?>";
        }
      
        else{
          $('#revNo').val(data.REV);
          $('#sciNo').val(data.SCI);

          window.location.replace('viewSCI.php?sciNo='+data.SCI);
         
        }
      }
    });
  }

});

}



  </script>


  <script>
    // initialize manually with a list of links
    /*$('[data-gallery=photoviewer]').click(function (e) {

      e.preventDefault();

      var items = [],
        options = {
          index: $(this).index(),
          modalWidth: 1500,
          modalHeight: 20,
          draggable:false,
          initMaximized:false,
          headerToolbar: ['maximize'],
          footerToolbar: ['zoomIn','zoomOut','fullscreen','actualSize','rotateRight'],
          animationEasing:'ease-in-out',
          initModalPos:{top:0, left: 200, bottom:0},
          appendTo:'body',






        };

      $('[data-gallery=photoviewer]').each(function () {
        items.push({
          src: $(this).attr('href'),
          title: $(this).attr('data-title')
        });
      });

      new PhotoViewer(items, options);

    });*/


        $('[data-gallery=photoviewer]').click(function (e) {

      e.preventDefault();

      var items = [],
        options = {
          index: $(this).index(),
          modalWidth: 1500,
          draggable:false,
        };

      $('[data-gallery=photoviewer]').each(function () {
        items.push({
          src: $(this).attr('href'),
          title: $(this).attr('data-title')
        });
      });

      new PhotoViewer(items, options);

    });



    function viewImg(){
     document.getElementById('gallery').click();


    }
  </script>

</body>

</html>