<?php
session_start();
$title = 'sci_maindata';
$page = 'sci_data';
$user_login = $_SESSION['pdau_id'];
date_default_timezone_set('Asia/Singapore');

include '../global/conn.php';

include '../global/userInfo.php';
include '../process/dashboard_details.php';

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
      <h1>SCI Master List
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
              <a href="../process/exportMasterData.php" class="btn btn-success" style="float:right;"><i class="bi bi-file-earmark-excel"></i> Export Master List</a>
            </br>
            </br>
                  <table id="example" class="table table-bordless table-hover" name="tblMasterlist"  style="font-size:13px;">
                    <thead>
                      <tr>
                        <th scope="col">Date Modify</th>
                        <th scope="col">Section</th>
                        <th scope="col">SCI No</th>
                        <th scope="col" style="width: 15%">Title</th>
                        <th scope="col" style="width: 10%">Model</th>
                        <th scope="col">Validity</th>
                        <th scope="col">ValidityDate</th>
                        <th scope="col">IssuanceDate</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
                if ($accountCode == 3) {
                  $sql = "SELECT * FROM SCI_MainData WHERE Status= 'Active' ORDER BY SCINo DESC";
                }
                else{
                  $sql = "SELECT * 
                                  FROM SCI_MainData 
                                  WHERE (Section = '$section'
                                        OR Section IN (SELECT Section 
                                                              FROM AdditionalSection 
                                                              WHERE BIPH_ID = '$user_login'))

                                  AND Status='Active' ORDER BY SCINo DESC";

                  // $sql = "SELECT * 
                  //                 FROM SCI_Request
                  //                 WHERE (RequestSection = '$section'
                  //                       OR RequestSection IN (SELECT Section 
                  //                                             FROM AdditionalSection 
                  //                                             WHERE BIPH_ID = '$user_login'))
                  //                   AND Status = 'Inactive' ORDER BY ID ASC";
                }
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $DateModified = $row['DateModified'];
                  $Section = $row['Section'];
                  $SCINo = $row['SCINo'];
                  $RevNo = $row['RevNo'];
                  $Title = $row['Title'];
                  $Model = $row['Model'];
                  $Validity = $row['Validity'];
                  $ValidityDate = $row['ValidityDate'];
                  $IssuanceDate = $row['IssuanceDate'];
                  $SCIFile = $row['SCIFile'];
                  $Status = $row['Status'];

                  $SCINo_final = $SCINo.'-'.$RevNo;
                 
                    echo '
                    <tr>
                    <td>'.$DateModified.'</td>
                    <td>'.$Section.'</td>
                    <td><b>'.$SCINo_final.'</b></td>
                    <td>'.$Title.'</td>
                    <td>'.$Model.'</td>
                    <td>'.$Validity.'</td>
                    <td>'.$ValidityDate.'</td>
                    <td>'.$IssuanceDate.'</td>
                    <td>
                    ';
                   ?>
                    <a href="viewSCI.php?sciNo=<?php echo $SCINo; ?>" target="_blank" title="SCI Document" id="launchModal"><img src="../assets/img/pdf.png" width="25px;" name="btnViewSCI"></a>
                    <a class="openDocsLogs" id="launchModal" href="#" data-id="<?php echo $SCINo ?>" data-toggle="modal" data-target="#viewDocsLogs"><img src="../assets/img/log.png" width="25px;"  title="View SCI History"></a>
                   <!--  <a href="#"  title="Dissemination File"><img src="../assets/img/signature.png" width="25px;"></a> -->
                 </td>
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
      <div class="modal fade" id="viewDocsLogs" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="displayDocsLogs"></div>
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
        initComplete: function () {
          this.api()
          .columns([1,2,3,4])
          .every(function () {
            let column = this;
            let title = column.header().textContent;

                // Create input element
                let input = document.createElement('input');
                input.style.cssText = 'width:90px;font-size:14px;';
                input.type = 'text';
                input.placeholder = title;
                column.header().replaceChildren(input);

                // Event listener for user input
                input.addEventListener('keyup', () => {
                  if (column.search() !== this.value) {
                    column.search(input.value).draw();
                  }
                });
              });

        },
        columnDefs: [
        { orderable: false, targets: [0,1,2,3,4,5,6,7,8] }
        ],
        order: [[1, 'asc']],

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