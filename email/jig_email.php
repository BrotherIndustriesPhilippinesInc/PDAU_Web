<?php
$activityID = $_GET['actid'];
include '../global/conn.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Jig Audit | Process Documents Auto Updater</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="../assets/img/mail.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

</head>


<body>

  <main>
    <div class="container">

      <section class="section register min-vh-1000 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-12">

              <div class="card mb-12">

                <div class="card-body overflow-auto">

                  <div class="pt-12 pb-12">
                    <h5 class="card-title text-center pb-100 fs-2">Jig Audit
                    </h5>
                 
                    <br>
                  </div>

                  <table class="table datatable" style="font-size: 15px;">
                    <thead>
                      <tr>
                      	<th scope="col">Image</th>
                        <th scope="col">Model</th>
                        <th scope="col">Process</th>
                        <th scope="col">ProcessNo</th>
                        <th scope="col">Jig Code</th>
                        <th scope="col">Jig Name</th>
                        <th scope="col">WorkI</th>
                        <th scope="col">Judgment</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
    
                include '../global/conn.php';
                $sql = "SELECT * FROM Temp_Jigs WHERE Judgement = 'No Good' AND ActID = '".$activityID."' ORDER BY ID";
                $stmt = sqlsrv_query($conn2,$sql);
                while($resultQuery = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                  $id =  $resultQuery['ID'];
                    $model = $resultQuery['Model'];
                    $process = $resultQuery['AssemblyName'];
                    $processno = $resultQuery['ProcessNo'];
                    $jigcode = $resultQuery['JigCode']; 
                    $jigname = $resultQuery['Jigname']; 
                    $jigimage = $resultQuery['JigImage']; 
                    $workino = $resultQuery['WorkINo'];
                    $actID = $resultQuery['ActID'];
                    $judgment = $resultQuery['Judgement'];
                    $jigimage = $resultQuery['JigImage']; 
                    $jigimage = str_replace("/","\\",$jigimage);
                    $jigimage = str_replace("\\\apbiphbpswb01","..",$jigimage);
                     echo "
                      <tr>
                      <td><a href='".$jigimage."' target='_blank'><img src='".$jigimage."' alt='Jig' height='60px;width='50px;' title='Click the picture to see details' ></a></td>
                      <td>".$model."</td>
                      <td>".$process."</td>
                      <td>".$processno."</td>
                      <td>".$jigcode."</td>
                      <td>".$jigname."</td>
                      <td>".$workino."</td>
                      <td style='color:red'><strong>".$judgment."</strong></td>
                      ";
                     
                    }
                        ?>

                    </tr>
                      </ul>
                    </div>
                  
                    </tbody>

                  </table>

                </div>
              </div>


            </div>
          </div>
        </div>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
<!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Bootstrap library -->

</body>

</html>