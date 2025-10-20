<?php
if ($accounttype == 'SUPERVISOR') {
  $sql = "SELECT COUNT(ID) as TotalNotif FROM SCI_Request WHERE SPV = '$fullname' AND Status ='SPV APPROVAL'";
}
elseif($accounttype == 'MANAGER'){
  $sql = "SELECT  COUNT(ID) as TotalNotif FROM SCI_Request WHERE MGR = '$fullname' AND Status ='MGR APPROVAL' ";
}

$stmt = sqlsrv_query($conn2,$sql);
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $TotalNotif = $row['TotalNotif'];
}
if ($TotalNotif == 0) {
  $final_notif = "";
}
else{
  $final_notif = $TotalNotif;
}


if ($accountCode != 3) {
  $sqlImp = "SELECT COUNT(ID) as totalImplement FROM SCI_Request WHERE Status= 'APPROVED' AND RequestSection = '$section' AND Implement=0 ";
  $stmtImp = sqlsrv_query($conn2,$sqlImp);
  while($rowImp = sqlsrv_fetch_array($stmtImp, SQLSRV_FETCH_ASSOC)) {
    $totalImplement = $rowImp['totalImplement'];
  }
}
else{
  $totalImplement == 0;
}

if ($totalImplement == 0) {
  $final_Imp = "";
}
else{
  $final_Imp = $totalImplement;
}






?>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
<!--*******  SIDEBAR FOR PRINTER SECTION *******-->
 <?php if ($systemNo == 1): ?>

      <!--******* DASHBOARD *******-->
      <?php
      if ($title == 'dashboard') {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="../forms/dashboard.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php
      }
      else{
        ?>
         <li class="nav-item">
          <a class="nav-link collapsed" href="../forms/dashboard.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php
      }
      ?>
    <!--******* END DASHBOARD *******-->

    <!--******* REQUEST FOR UPDATE *******-->

        <?php
        if ($accounttype == 'SUPERVISOR') {
          if ($page == 'requestSPV') {
            ?>
            <li class="nav-item">
              <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-arrow-repeat"></i><span>Request For Update</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav" class="nav-content components-show" data-bs-parent="#sidebar-nav">
                <?php
                if ($title == 'requestupdate') {
                 ?>
                  <li>
                  <a href="../forms/RequestForApproval.php" class="active">
                    <i class="bi bi-circle"></i><span>For Approval</span>
                  </a>
                </li>
                 <?php
                }
                else{
                  ?>
                   <li>
                  <a href="../forms/RequestForApproval.php">
                    <i class="bi bi-circle"></i><span>For Approval</span>
                  </a>
                </li>
                  <?php
                }
                ?>

                 <?php
                if ($title == 'requestHistory') {
                 ?>
                  <li>
                  <a href="../forms/RequestHistory.php" class="active">
                    <i class="bi bi-circle"></i><span>Approval History</span>
                  </a>
                </li>
                 <?php
                }
                else{
                  ?>
                  <li>
                    <a href="../forms/RequestHistory.php">
                      <i class="bi bi-circle"></i><span>Approval History</span>
                    </a>
                  </li>
                  <?php
                }
                ?>
              </ul>
            </li>
            <?php
          }
          else{
            ?>
            <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-arrow-repeat"></i><span>Request For Update</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="../forms/RequestForApproval.php">
                    <i class="bi bi-circle"></i><span>For Approval</span>
                  </a>
                </li>
                <li>
                  <a href="../forms/RequestHistory.php">
                    <i class="bi bi-circle"></i><span>Approval History</span>
                  </a>
                </li>
              </ul>
            </li>

            <?php
          }
        }
        ?>

     <!--******* END REQUEST FOR UPDATE *******-->

     <!--******* PROCESS CHECKING *******-->
      <?php
      if ($page == 'processChecking') {
        ?>
        <li class="nav-item">
          <a class="nav-link" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
           <i class="bi bi-clipboard-check"></i></i><span>Process Checking</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="forms-nav" class="nav-content" data-bs-parent="#sidebar-nav">
          <?php
          if ($title == 'processCheck') {
            ?>
             <li>
            <a href="../forms/ProcessChecking.php" class="active">
              <i class="bi bi-circle"></i><span>For Approval</span>
            </a>
          </li>
            <?php
          }
          else{
             ?>
             <li>
            <a href="../forms/ProcessChecking.php">
              <i class="bi bi-circle"></i><span>For Approval</span>
            </a>
          </li>
            <?php
          }

          if ($title == 'processHistory') {
           ?>
           <li>
            <a href="../forms/ProcessHistory.php" class="active">
              <i class="bi bi-circle"></i><span>Approval History</span>
            </a>
          </li>
           <?php
          }
          else{
            ?>
            <li>
            <a href="../forms/ProcessHistory.php">
              <i class="bi bi-circle"></i><span>Approval History</span>
            </a>
          </li>
            <?php
          }
          ?>
        </ul>
      </li>
        <?php
      }
      else{
        ?>
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
           <i class="bi bi-clipboard-check"></i></i><span>Process Checking</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../forms/ProcessChecking.php">
              <i class="bi bi-circle"></i><span>For Approval</span>
            </a>
          </li>
          <li>
            <a href="../forms/ProcessHistory.php">
              <i class="bi bi-circle"></i><span>Approval History</span>
            </a>
          </li>
        </ul>
      </li>
        <?php

      }

      ?>
      <!--******* END PROCESS CHECKING *******-->

   

 <?php endif ?>
<!--************************************************* END OF PRINTER SECTION *****************************************************************-->


      <?php if ($systemNo == 2): ?>

        <!--******* DASHBOARD *******-->
        <?php
        if ($title == 'dashboard') {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="../forms/dashboard-sci.php" name="btnDashboard">
              <i class="bi bi-grid"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <?php
        }
        else{
          ?>
          <li class="nav-item">
            <a class="nav-link collapsed" href="../forms/dashboard-sci.php" name="btnDashboard">
              <i class="bi bi-grid"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <?php
        }
        ?>
        <!--******* END DASHBOARD *******-->


        <!--******* Request for SCI *******-->
        <?php
        if ($page == 'sci') {
          ?>
           <li class="nav-item">
        <a class="nav-link" data-bs-target="#sciRequest" data-bs-toggle="collapse" href="#">
          <i class="bi bi-envelope-check"></i><span>SCI Request </span> <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sciRequest" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <?php
            if ($title == 'sciRequest') {
             echo '<a href="../forms/createRequest.php" class="active">';
            }
            else{
              echo '<a href="../forms/createRequest.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Create Request</span>
            </a>
          </li>
          <li>
            <?php
            if ($title == 'sciOngoing'|| $title == 'reApply') {
             echo ' <a href="../forms/ongoingRequest.php" class="active">';
            }
            else{
              echo ' <a href="../forms/ongoingRequest.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Ongoing Request</span>
            </a>
          </li>
          <li>
            <?php
            if ($title=='sciHistory') {
              echo '<a href="../forms/sciAcceptedDeclined.php" class="active">';
            }
            else{
               echo '<a href="../forms/sciAcceptedDeclined.php">';
            }
            ?>
            
              <i class="bi bi-circle"></i><span>Approved/Cancelled</span>
            </a>
          </li>
          <li>
            <?php
            if ($title=='sciAdminCancel') {
              echo '<a href="../forms/sciAdminCancel.php" class="active">';
            }
            else{
               echo '<a href="../forms/sciAdminCancel.php">';
            }
            ?>
            
              <i class="bi bi-circle"></i><span>Admin Cancel</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

          <?php
        }
        else{
          ?>
         <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sciRequest" data-bs-toggle="collapse" href="#">
          <i class="bi bi-envelope-check"></i><span>SCI Request </span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sciRequest" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../forms/createRequest.php">
              <i class="bi bi-circle"></i><span>Create Request</span>
            </a>
          </li>
          <li>
            <a href="../forms/ongoingRequest.php">
              <i class="bi bi-circle"></i><span>Ongoing Request</span>
            </a>
          </li>
          <li>
            <a href="../forms/sciAcceptedDeclined.php">
              <i class="bi bi-circle"></i><span>Accepted/Cancelled</span>
            </a>
          </li>
          <li>
            <a href="../forms/sciAdminCancel.php">
              <i class="bi bi-circle"></i><span>Admin Cancel</span>
            </a>
          </li>
        </ul>
      </li>
          <?php
        }
        ?>
        <!--******* END SCI REQUEST *******-->



        <?php if ($accountCode!=3): ?>
          
      <?php if ($accounttype == 'MANAGER' || $accounttype == 'SUPERVISOR' || $accounttype == 'ADMIN'): ?>
        
      
        <!--******* SCI APPROVAL *******-->
        <?php
        if ($page == 'sciApproval') {
          ?>
           <li class="nav-item">
        <a class="nav-link" data-bs-target="#sciApproval" data-bs-toggle="collapse" href="#">
         <i class="bi bi-person-check"></i><span>SCI Approval <span class="badge bg-danger text-light"><?php echo $final_notif; ?></span></span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sciApproval" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <?php
            if ($title == 'sciForApproval') {
             echo '<a href="../forms/sciForApproval.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciForApproval.php">';
            }

            if ($final_notif!="") {
              echo '<i class="bi bi-circle"></i><span style="color:red">For Approval</span>';
            }
            else{
               echo '<i class="bi bi-circle"></i><span>For Approval</span>';
            }
            ?>
              
            </a>
          <li>
          </li>
            <?php
            if ($title == 'sciApprovalHistory') {
             echo ' <a href="../forms/sciApprovalHistory.php" class="active">';
            }
            else{
              echo ' <a href="../forms/sciApprovalHistory.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Approval History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

          <?php
        }
        else{
          ?>
         <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sciApproval" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-check"></i><span>SCI Approval <span class="badge bg-danger text-light"><?php echo $final_notif; ?></span></span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sciApproval" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../forms/sciForApproval.php">
              <?php
              if ($final_notif!="") {
                echo '<i class="bi bi-circle"></i><span style="color:red">For Approval</span>';
              }
              else{
               echo '<i class="bi bi-circle"></i><span>For Approval</span>';
             }
              ?>
            </a>
          </li>
          <li>
            <a href="../forms/sciApprovalHistory.php">
              <i class="bi bi-circle"></i><span>Approval History</span>
            </a>
          </li>
        </ul>
      </li>
          <?php
        }
        ?>
        <!--******* END SCI APPROVAL *******-->
         <?php endif ?>

         <?php endif ?>


            <!--******* SCI APPROVAL *******-->
        <?php
        if ($page == 'sci_data') {
          ?>
           <li class="nav-item">
        <a class="nav-link" data-bs-target="#sci_data" data-bs-toggle="collapse" href="#">
         <i class="bi bi-file-earmark-pdf"></i><span>SCI Documents <span class="badge bg-danger text-light"><?php echo $final_Imp; ?></span></span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sci_data" class="nav-content collapse show" data-bs-parent="#sidebar-nav">

          <li>
            <?php
            if ($title == 'sci_maindata') {
             echo '<a href="../forms/sciMainData.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciMainData.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Master List</span>
            </a>
            </li>

            <li>
            <?php
            if ($title == 'sci_implement') {
             echo '<a href="../forms/sciImplement.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciImplement.php">';
            }
            if ($final_Imp!="") {
              echo '<i class="bi bi-circle"></i><span style="color:red">For Implementation</span>';
            }
            else{
               echo '<i class="bi bi-circle"></i><span>For Implementation</span>';
            }
            ?>
              
            </a>
          </li>

          <li>
            <?php
            if ($title == 'sci_abolish') {
             echo '<a href="../forms/sciAbolishData.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciAbolishData.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Abolished Data</span>
            </a>
          </li>



          <li>
            <?php
            if ($title == 'Upload Data') {
             echo '<a href="../forms/sciUploadDataLogs.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciUploadDataLogs.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Upload Data (Admin)</span>
            </a>
          </li>


        </ul>
      </li><!-- End Tables Nav -->

          <?php
        }
        else{
          ?>
         <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sci_data" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-pdf"></i><span>SCI Documents <span class="badge bg-danger text-light"><?php echo $final_Imp; ?></span></span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sci_data" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../forms/sciMainData.php" name="btnMasterlist">
              <i class="bi bi-circle"></i><span>Master List</span>
            </a>
          </li>
          <li>
            <a href="../forms/sciImplement.php">
              <?php
              if ($final_Imp!="") {
                echo '<i class="bi bi-circle"></i><span style="color:red">For Implementation</span>';
              }
              else{
                echo '<i class="bi bi-circle"></i><span>For Implementation</span>';
            }
            ?>
            </a>
          </li>
          <li>
            <a href="../forms/sciAbolishData.php">
              <i class="bi bi-circle"></i><span>Abolished Data</span>
            </a>
          </li>

          <li>
            <?php
            if ($title == 'Upload Data') {
             echo '<a href="../forms/sciUploadDataLogs.php" class="active">';
            }
            else{
              echo '<a href="../forms/sciUploadDataLogs.php">';
            }
            ?>
              <i class="bi bi-circle"></i><span>Upload Data (Admin)</span>
            </a>
          </li>

        </ul>
      </li>
          <?php
        }
        ?>
        <!--******* END SCI APPROVAL *******-->







        <!--******* ACCOUNTS *******-->
        <?php
        if ($accounttype =='ADMIN') {
          
        if ($title == 'accounts') {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="../forms/accounts.php">
              <i class="bi bi-people"></i>
              <span>Accounts</span>
            </a>
          </li>
          <?php
        }
        else{
          ?>
          <li class="nav-item">
            <a class="nav-link collapsed" href="accounts.php">
              <i class="bi bi-people"></i>
              <span>Accounts</span>
            </a>
          </li>
          <?php
        }
      }
        ?>
        
      <?php endif ?>
<!--**************************************************** END OF SCI *****************************************************************-->

         <!--******* MY PROFILE *******-->
      <?php
      if ($title == 'myProfile') {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="../forms/myProfile.php">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <?php
      }
      else{
        ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="../forms/myProfile.php">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <?php
      }
      ?>
      <!--******* END MY PROFILE *******-->
    </ul>
  </aside>

