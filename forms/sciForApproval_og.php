<?php
session_start();
$page = "sciApproval";
$title = 'sciForApproval';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';

include '../global/userInfo.php';
/*include '../process/dashboard_details.php';*/


/*$sql3 = "SELECT MAX(ID)+1 as lastID FROM SCI_Request";
$stmt3 = sqlsrv_query($conn2,$sql3);
while($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
  $lastID = $row3['lastID'];
  if ($lastID == null || $lastID == "") {
    $requestID = "REQUEST-SCI-1";
  }
  else{
    $requestID = "REQUEST-SCI-".$lastID;
  }
  
}*/


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
</style>
<?php include '../global/head.php'; ?>


<body>

 <?php include '../global/header.php'; ?>

  <?php include '../global/sidebar.php'; ?>

   <?php include_once '../global/session_validator.php';?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>For Approval
      </h1>
    </div><!-- End Page Title -->
   
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
             <!--  <img src="assets/img/underConstruction.png" alt="Profile"  width="1200" height="600"> -->
              <br>
             <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <div class="col-12 overflow-auto">
                  <table id="example" class="table table-bordless"  style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col" width="13%">Date</th>
                        <th scope="col" width="10%">RequestID</th>
                        <th scope="col" width="5%">Section</th>
                        <th scope="col" width="7%">Type</th>
                        <th scope="col" width="15%">SCI No</th>
                        <th scope="col" width="25%">Title</th>
                        <th scope="col" width="15%">Model</th>
                        <th scope="col" width="10%">Status/Action</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                if ($accounttype == 'SUPERVISOR') {
                  $sql = "SELECT * FROM SCI_Request WHERE SPV = '$fullname' AND Status ='SPV APPROVAL' ORDER BY ID DESC";
                }
                elseif($accounttype == 'MANAGER'){
                  $sql = "SELECT * FROM SCI_Request WHERE MGR = '$fullname' AND Status ='MGR APPROVAL' ORDER BY ID DESC";
                }
                else{
                  ?>
                  <script type="text/javascript">
                    alert('Access Denied!');
                    window.location.replace('dashboard-sci.php');
                  </script>
                  <?php
                }
                
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $RequestDate = $row['RequestDate'];
                  $RequestID = $row['RequestID'];
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
                  $Requestor = $row['Requestor'];
                  $RequestSection = $row['RequestSection'];
                  $SCIExcel = $row['SCIExcel'];
                  $SCIPDF = $row['SCIPDF'];
                  $SCIForProcess = $row['SCIForProcess'];
                  $Status = $row['Status'];

                  if ($RequestType == 'NEW') {
                    $SCINo_final = $SCINo;
                  }
                  else{
                    $SCINo_final = $SCINo.'-'.$RevNo;
                  }
                    echo '
                    <tr>
                    <td>'.$RequestDate.'</td>
                    <td>'.$RequestID.'</td>
                    <td>'.$RequestSection.'</td>
                    ';
                    if ($RequestType == 'NEW') {
                      echo ' <td class="text-success"><b>'.$RequestType.'</b></td>';
                    }
                    elseif ($RequestType == 'REVISION') {
                      echo ' <td class="text-primary"><b>'.$RequestType.'</b></td>';
                    }
                    else{
                      echo ' <td class="text-warning"><b>'.$RequestType.'</b></td>';
                    }
                    echo '
                    <td>'.$SCINo_final.'</td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    <td> <a href="sciForApproval-details.php?reqID='.$RequestID.'" class="btn btn-sm btn-primary" title="'.$Status.'"><b>'.$Status.'</b></a></td>
                   ';
                  
                   ?>
                   
                </tr>
                   <?php
                    }
                 ?>
                  
                    </tbody>

                  </table>


                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
      </div>
    </section>


    <section>
      <div class="modal fade" id="viewApprovalStatus" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="displayApprovalStatus"></div>
         </div>
       </div>
     </div>
    </section>


    <section>
      <div class="modal fade" id="viewSCILogs" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="displaySCILogs"></div>
         </div>
       </div>
     </div>
   </section>


   <section>
    <div class="modal fade" id="viewRejected" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="displayRejected"></div>
        </div>
      </div>
    </div>
  </section>

  

  </main>


  <!-- ======= Footer ======= -->
  <?php include '../global/footer.php'; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <?php include '../global/scripts.php'; ?>

  


 <script type="text/javascript">

    $(document).ready( function () {

      new DataTable('#example', {
     
        columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6] }
        ],
        order: false
      });




   /*   
  
  var table = $('#example').DataTable({
            initComplete: function () {
            count = 0;
            this.api().columns([1]).every( function () {
                var title = this.header();
                //replace spaces with dashes
                title = $(title).html().replace(/[\W]/g, '-');
                var column = this;
                var select = $('<select id="' + title + '" class="select2" ></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                      //Get the "text" property from each selected data 
                      //regex escape the value and store in array
                      var data = $.map( $(this).select2('data'), function( value, key ) {
                        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                 });
                      
                      //if no data selected use ""
                      if (data.length === 0) {
                        data = [""];
                      }
                      
                      //join array into string with regex or (|)
                      var val = data.join('|');
                      
                      //search for the option(s) selected
                      column
                            .search( val ? val : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                } );
              
              //use column title as selector and placeholder
              $('#' + title).select2({
                multiple: true,
                closeOnSelect: false,
                placeholder: "Select a " + title
              });
              
              //initially clear select otherwise first option is selected
              $('.select2').val(null).trigger('change');
            } );
        },
        columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7,8,9] }
        ],
        order: [[1, 'asc']]
  });*/
} );
  </script>

</body>

</html>