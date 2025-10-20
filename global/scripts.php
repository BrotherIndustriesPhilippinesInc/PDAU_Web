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
  <script src="../assets/js/ajax.googleapis.com_ajax_libs_jquery_3.4.1_jquery.min.js"></script>
<!-- Bootstrap library -->
<script src="../assets/js/maxcdn.bootstrapcdn.com_bootstrap_4.0.0_js_bootstrap.min.js"></script>

<script src="../assets/js/cdnjs.cloudflare.com_ajax_libs_sweetalert_1.1.3_sweetalert-dev.js"></script>


<script src="../assets/js/code.jquery.com_jquery-3.7.0.js"></script>
 <script src="../assets/js/cdn.datatables.net_1.13.6_js_jquery.dataTables.min.js"></script>
 <script src="../assets/js/cdnjs.cloudflare.com_ajax_libs_select2_4.0.3_js_select2.min.js"></script>


<script type="text/javascript">

    $('table tbody').on('click', '.openApprovalStatus', function() {
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/approvalStatus.php?id="+id,cache:false,success:function(result){
        $(".displayApprovalStatus").html(result);
      }});
    });

     $('div').on('click', '.openSCILogs', function() {
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/sci_requestLogs.php?id="+id,cache:false,success:function(result){
        $(".displaySCILogs").html(result);
      }});
    });


     $('table tbody').on('click', '.openRejected', function() {
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/rejected.php?id="+id,cache:false,success:function(result){
        $(".displayRejected").html(result);
      }});
    });

     $('table tbody').on('click', '.openDocsLogs', function() {
      var id = $(this).attr('data-id');
     $.ajax({url:"../modal/sci_documentLogs.php?id="+id,cache:false,success:function(result){
        $(".displayDocsLogs").html(result);
      }});
    });

     $('table tbody').on('click', '.openCancelled', function() {
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/cancelled.php?id="+id,cache:false,success:function(result){
        $(".displayCancelled").html(result);
      }});
    });

      $('.openDocsLogsDetails').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({url:"../modal/sci_documentLogs.php?id="+id,cache:false,success:function(result){
        $(".displayDocsLogsDetails").html(result);
      }});
    });




//DISABLE AUTO LOGOUT

/*var refreshTime = 600000; // every 10 minutes in milliseconds*/


var refreshSession = setInterval(refreshSession, 600000);    
function refreshSession () {

var session_user = "<?php echo $_SESSION['pdau_id'] ?>";

  $.ajax({
    url:"../global/refreshSession.php",
    cache: false,
    method:"GET",
    success:function(data)
    {
      /*alert("hALO");*/
    }
  });
}

</script>


<button hidden id="btnLoading" onclick="setTimeout(function() {
  swal({
    title: 'Processing...', 
    text: 'Please wait while processing the data', 
    imageUrl: '../assets/img/pdau_loading.gif',    
    showConfirmButton: false,
    confirmButtonText: 'Ok',   
    closeOnConfirm: true 
}, function(){
    window.Close();
});
}, 100);">TEST</button>
