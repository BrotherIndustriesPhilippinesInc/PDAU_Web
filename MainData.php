<?php
session_start();
$title = 'maindata';
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
<?php include 'global/head.php'; ?>
<body>

  <?php include 'global/header.php'; ?>

  <?php include 'global/sidebar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Main Data [Work Instruction]</h1>
<!-- 
      <?php 
      date_default_timezone_set('Asia/Singapore');
      echo date("Ymdhi");  ?> -->
    </div><!-- End Page Title -->

    <section>
      <!-- Recent Sales -->
      <div class="col-12">
        <div class="card recent-sales overflow-auto">
          <div class="card-body" style="min-height:400px;">
            <h5 class="card-title"></h5>
            <table class="table datatable" style="font-size:14px;">
              <thead>
                <tr>
                  <th scope="col">Model</th>
                  <th scope="col">Process</th>
                  <th scope="col">ProcessNo</th>
                  <th scope="col">Element</th>
                  <th scope="col">ElementNo</th>
                  <th scope="col">WorkI</th>
                  <th scope="col">Sequence</th>
                  <!-- <th scope="col"></th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                include 'global/conn.php';
                $sql = "SELECT * FROM MasterData ORDER BY Model,SeriesNo asc ";
                $stmt = sqlsrv_query($conn2,$sql);
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id = $row['ID'];
                  $Model = $row['Model'];
                  $Process = $row['Process'];
                  $ProcessNo = $row['ProcessNo'];
                  $ElementName = $row['ElementName'];
                  $ElementNo = $row['ElementNo'];
                  $WorkINo = $row['WorkINo'];
                  $SeriesNo = $row['SeriesNo'];
                  $WorkIFilename = $row['WorkIFilename'];
                  $Uploaded_date = $row['Uploaded_date'];
                 
                  $attachment = str_replace("\\", "/", $WorkIFilename);
                  /*$attachment = substr($WorkIFilename, 35);*/

                  $filePath = "../../PDAUS".''.$WorkIFilename;

                  echo '
                  <tr>
                  <td>'.$Model.'</td>
                  <td>'.$Process.'</td>
                  <td>'.$ProcessNo.'</td>
                  <td>'.$ElementName.'</td>
                  <td>'.$ElementNo.'</td>
                  <td>'.$WorkINo.'</td>
                  <td>'.$SeriesNo.'</td>
                  <td>
                  ';
                  ?>
                  <a class="btn btn-danger" target="_blank" href="<?php echo $attachment;?>" name="viewAttachment" id="viewAttachment">
                    <i class="bi bi-file-pdf-fill"></i>
                  </a>
                  <?php
                }
                ?>
            </td>
              </tr>
            </tbody>
          </table>

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

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'global/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<?php include 'global/scripts.php'; ?>

<script>
  $('.openModal').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"modal/declineRequest.php?id="+id,cache:false,success:function(result){
      $(".declineRequest1").html(result);
    }});
  });
</script>
<script>
  $('.openModal1').click(function(){
    var id = $(this).attr('data-id');
    $.ajax({url:"modal/viewDetails.php?id="+id,cache:false,success:function(result){
      $(".viewDetails1").html(result);
    }});
  });
</script>
</body>

</html>