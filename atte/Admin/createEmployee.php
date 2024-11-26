<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include 'Includes/session.php';

function getTilejobs($conn) {
  $sql = "SELECT TitlejobId,TitlejobName FROM tbltitlejobs";
  $result = $conn->query($sql);

  $titlejobNames = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $titlejobNames[] = $row;
    }
  }

  return $titlejobNames;
}

function getCompanies($conn) {
  $sql = "SELECT ComName FROM tblcompanystructure WHERE ComType = 'Company'";
  $result = $conn->query($sql);

  $companytNames = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $companytNames[] = $row;
    }
  }

  return $companytNames;
}

function getDepartments($conn) {
  $sql = "SELECT ComName FROM tblcompanystructure WHERE ComType = 'Department'";
  $result = $conn->query($sql);

  $departmentNames = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $departmentNames[] = $row;
    }
  }

  return $departmentNames;
}

function getBranches($conn) {
  $sql = "SELECT ComName FROM tblcompanystructure WHERE ComType = 'Branch'";
  $result = $conn->query($sql);

  $branchNames = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $branchNames[] = $row;
    }
  }

  return $branchNames;
}

function getShift($conn) {
  $sql = "SELECT shiftId,shiftName FROM tblshift";
  $result = $conn->query($sql);

  $shiftNames = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $shiftNames[] = $row;
      }
  }

  return $shiftNames;
}

if(isset($_POST['saveEmployee'])){
  $empId=$_POST['empId'];
  $empFullname=$_POST['empFullname'];
  $empEmail=$_POST['empEmail'];
  $empTitlejob=$_POST['empTitlejob'];
  $empCompany=$_POST['empCompany'];
  $empBranch=$_POST['empBranch'];
  $empDepartment=$_POST['empDepartment'];
  $empWorkNum=$_POST['empWorkNum'];
  $empPrivateNum=$_POST['empPrivateNum'];
  $empAddress=$_POST['empAddress'];
  $empGender=$_POST['empGender'];
  $empMaritalstatus=$_POST['empMaritalstatus'];
  $empNationalID=$_POST['empNationalID'];
  $empDrivinglicense=$_POST['empDrivinglicense'];
  $empShift=$_POST['empShift'];
  $empStatus=$_POST['empStatus'];
  $empNotes=$_POST['empNotes'];
  $dateRegistered = date("Y-m-d H:i");
  $empAttfiles=$_POST['empAttfiles'];
  $capturedImage1 = $_POST['capturedImage1'];
  $capturedImage2 = $_POST['capturedImage2'];
  $base64Data0 = explode(',', $empAttfiles)[1];
  $base64Data1 = explode(',', $capturedImage1)[1];
  $base64Data2 = explode(',', $capturedImage2)[1];
  $imageData0 = base64_decode($base64Data0);
  $imageData1 = base64_decode($base64Data1);
  $imageData2 = base64_decode($base64Data2);
  $empId = mysqli_real_escape_string($conn, $_POST['empId']);
  $folderPath = "../Manager/labels/{$empId}/";
  if (!file_exists($folderPath)) {
    mkdir($folderPath, 0777, true);
  }
  file_put_contents($folderPath . '0.png', $imageData0);
  file_put_contents($folderPath . '1.png', $imageData1);
  file_put_contents($folderPath . '2.png', $imageData2);
    $query=mysqli_query($conn,"SELECT * FROM tblemployees WHERE empId ='$empId'");
    $ret=mysqli_fetch_array($query);
    if($ret > 0){
      $message = "Employee with the give Registration No: $empId Exists!";
    }
    else{
      $query=mysqli_query($conn,"INSERT INTO tblemployees(empId,empFullname,empEmail,empTitlejob,empCompany,empBranch,empDepartment,empWorkNum,empPrivateNum,empAddress,empGender,empMaritalstatus,empNationalID,empDrivinglicense,empShift,empStatus,empAttfiles,employeeImage1,employeeImage2,empNotes,dateRegistered) 
      value('$empId','$empFullname','$empEmail','$empTitlejob','$empCompany','$empBranch','$empDepartment','$empWorkNum','$empPrivateNum','$empAddress','$empGender','$empMaritalstatus','$empNationalID','$empDrivinglicense','$empShift','$empStatus','$empId" . "_image0.png', '$empId" . "_image1.png', '$empId" . "_image2.png','$empNotes','$dateRegistered')");
      $message = " Employee : $empId Added Successfully";
      header('Location: http://localhost/atte/Admin/createEmployee.php');
      exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="author" content="Mohamed Adel">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="../Adm/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../Adm/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../Adm/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../Adm/plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../Adm/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../Adm/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../Adm/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../Adm/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../Adm/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../Adm/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../Adm/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="../Adm/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../Adm/plugins/dropzone/min/dropzone.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../Adm/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Adm/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <?php include 'includes/topbar.php';?>
    <?php include "Includes/sidebar.php";?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Employees</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../Admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Employees</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
                <section class="content">
                  <div id="overlay"></div>
                  <div class="container-fluid">
                  <div id="messageDiv" class="messageDiv" style="display:none;"></div>
                    <!-- /.row employees -->
                    <div class="row">
                      <div class="card" style="width:100%;">
                        <div class="card-header border-transparent">
                          <div class="title" id="saveEmployee">
                              <button class="add"><i class="fas fa-plus"></i>Add New Employee</button>
                          </div>
                          <!-- card Body -->
                          <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>TitleJob</th>
                                  <th>Company</th>
                                  <th>Department</th>
                                  <th>Status</th>
                                  
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $sql = "SELECT * FROM tblemployees";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["empId"] . "</td>";
                                        echo "<td>" . $row["empFullname"] . "</td>";
                                        echo "<td>" . $row["empEmail"] . "</td>";
                                        echo "<td>" . $row["empTitlejob"] . "</td>";
                                        echo "<td>" . $row["empCompany"] . "</td>";
                                        echo "<td>" . $row["empBranch"] . "</td>";
                                        echo "<td>" . $row["empDepartment"] . "</td>";
                                        echo "<td>" . $row["empStates"] . "</td>";
                                        
                                        echo "</tr>";
                                    }
                                    }else {
                                      echo "<tr><td colspan='6'>No records found</td></tr>";
                                    }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- Form-responsive -->
                          <div class="formDiv--" id="addEmployeeForm" style="display:none;"> 
                            <form method="post">
                              <div style="display:flex; justify-content:space-around;">
                                <div>
                                  <span class="close">&times;</span>
                                </div>
                              </div>

                              <div>
                                <div>
                                  <!-- general form elements -->
                                  <!-- /.card-header -->
                                  <div class="card card-primary">
                                    <div class="card-header">
                                      <h3 class="card-title">Basic Info</h3>
                                    </div>
                  
                                    <!-- form start -->
                                    <!-- card-body 1 -->
                                    <div class="card-body">
                                      <div class="form-group" style="width:70%;">
                                        <label>Employee ID</label>
                                        <input required type="text" class="form-control" name="empId" value="<?php echo $row['empId'];?>" placeholder="Enter ID">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Employee Name</label>
                                        <input required type="text" class="form-control" name="empFullname" value="<?php echo $row['empFullname'];?>" placeholder="Enter Employee Name">
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="empEmail" value="<?php echo $row['empEmail'];?>" placeholder="Enter Email">
                                      </div>

                                      <div class="form-group">
                                        <label>Title Job</label>
                                        <select required name="empTitlejob" class="form-control select2" style="width: 70%;">
                                          <?php
                                          $titlejobNames = getTilejobs($conn);
                                          foreach ($titlejobNames as $Titlejob) {
                                            echo '<option value="' . $Titlejob["TitlejobName"] . '">' . $Titlejob["TitlejobName"] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>

                                      <div class="form-group">
                                        <label>Company</label>
                                        <select required name="empCompany" class="form-control select2" data-placeholder="Select Company" style="width: 70%;">
                                          <?php
                                          $companyNames = getCompanies($conn);
                                          foreach ($companyNames as $Company) {
                                            echo '<option value="' . $Company["ComName"] . '">' . $Company["ComName"] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width: 70%;">
                                        <label>Branch</label>
                                        <select name="empBranch" class="select2" multiple="multiple" data-placeholder="Select Branch" >
                                          <?php
                                          $branchNames = getBranches($conn);
                                          foreach ($branchNames as $Branch) {
                                            echo '<option value="' . $Branch["ComName"] . '">' . $Branch["ComName"] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label>Department</label>
                                        <select name="empDepartment" class="form-control select2" data-placeholder="Select Department" style="width: 70%;">
                                          <?php
                                          $departmentNames = getDepartments($conn);
                                          foreach ($departmentNames as $Department) {
                                            echo '<option value="' . $Department["ComName"] . '">' . $Department["ComName"] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Work Num</label>
                                        <input type="text" class="form-control" name="empWorkNum" value="<?php echo $row['empWorkNum'];?>" placeholder="Enter Work Num">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Private Num</label>
                                        <input type="text" class="form-control" name="empPrivateNum" value="<?php echo $row['empPrivateNum'];?>" placeholder="Enter Private Num">
                                      </div>
                                      
                                      <div class="form-group" style="width:70%;">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="empAddress" value="<?php echo $row['empAddress'];?>" placeholder="Enter Last Name">
                                      </div>

                                      <div class="form-group">
                                        <label>Gender</label>
                                        <select name="empGender" class="form-control select2" style="width: 70%;">
                                          <option selected="selected">Male</option>
                                          <option>Female</option>
                                        </select>
                                      </div>

                                      <div class="form-group">
                                        <label>Marital_Status</label>
                                        <select name="empMaritalstatus" class="form-control select2" style="width: 70%;">
                                          <option selected="selected">Married</option>
                                          <option>Single</option>
                                          <option>Divorced</option>
                                          <option>Widowed</option>
                                          <option>Other</option>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>National ID</label>
                                        <input type="text" class="form-control" name="empNationalID" value="<?php echo $row['empNationalID'];?>" placeholder="Enter National ID">
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>Driving License</label>
                                        <input type="text" class="form-control" name="empDrivingLicense" value="<?php echo $row['empDrivingLicense'];?>" placeholder="Enter Driving License">
                                      </div>

                                      <div class="form-group" style="width:100%;">
                                        <label>Shift Time</label>
                                        <select class="select2" name="empShift" multiple="multiple" data-placeholder="Select Shift Time" style="width: 70%;">
                                          <?php
                                          $shiftNames = getShift($conn);
                                          foreach ($shiftNames as $Shift) {
                                            echo '<option value="' . $Shift["shiftName"] . '">' . $Shift["shiftName"] . '</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label>Employee Status</label>
                                        <select name="empStatus" class="form-control select2" style="width: 70%;">
                                          <option selected="selected">Active</option>
                                          <option>Not Active</option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- card-body 2 --> 
                                    <div class="card-header" style="margin-bottom: 50px;">
                                      <h3 class="card-title">Documents</h3>
                                    </div>
                                    <div class="card-body">
                                      <div class="form-group" style="width:70%;">
                                        <label>File input</label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="InputFile" name="empAttfiles">
                                            <label class="custom-file-label">Choose file</label>
                                          </div>
                                          <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- card-body 3 -->
                                    <div class="card-body">
                                      <div class="form-group">
                                        <div class="image-box" onclick="openCamera('button1');">
                                          <img src="img/default.png" alt="Default Image" id="button1-captured-image">
                                          <div class="edit-icon">
                                            <i class="fas fa-camera" onclick="openCamera('button1');"></i>
                                          </div>
                                          <input type="hidden" id="button1-captured-image-input" name="capturedImage1" />
                                          <span style="text-align: center; display: block;">Face1</span>
                                        </div>
                                        <div class="image-box" onclick="openCamera('button2')">
                                          <img src="img/default.png" alt="Default Image" id="button2-captured-image">
                                          <div class="edit-icon">
                                            <i class="fas fa-camera" onclick="openCamera('button2')"></i>
                                          </div>
                                          <input type="hidden" id="button2-captured-image-input" name="capturedImage2" />
                                          <span style="text-align: center; display: block;">Face2</span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-footer">
                                      <button type="submit" class="btn btn-primary" value="Save Employee" name="saveEmployee">Save</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
    </div>
    <!-- Script open Input Form -->
    <script>
        const saveEmployee=document.getElementById('saveEmployee');
        const addEmployeeForm=document.getElementById("addEmployeeForm");
        saveEmployee.addEventListener("click",function(){
          addEmployeeForm.style.display = "block";
          overlay.style.display="block";
          addEmployeeForm.style.overflowY = 'scroll'; 
          document.body.style.overflow = 'hidden'; 
        })
            var closeButtons = document.querySelectorAll(' #addEmployeeForm .close');
            closeButtons.forEach(function(closeButton) {
              closeButton.addEventListener('click', function() {
                  addEmployeeForm.style.display="none";
                  overlay.style.display = 'none';
                  document.body.style.overflow = 'auto'; 
              });
            });     
    </script>
    <script src="javascript/addEmployee.js"></script>
    <!-- REQUIRED SCRIPTS -->
    <script src="../Adm/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../Adm/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../Adm/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../Adm/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../Adm/plugins/moment/moment.min.js"></script>
    <script src="../Adm/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="../Adm/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../Adm/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../Adm/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../Adm/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="../Adm/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="../Adm/plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../Adm/dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../Adm/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../Adm/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../Adm/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../Adm/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../Adm/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../Adm/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../Adm/plugins/jszip/jszip.min.js"></script>
    <script src="../Adm/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../Adm/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../Adm/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../Adm/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../Adm/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
    <!-- jQuery Mapael -->
    <script src="../Adm/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="../Adm/plugins/raphael/raphael.min.js"></script>
    <script src="../Adm/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="../Adm/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <script src="./javascript/confirmation.js"></script>
    <?php
      if(isset($message)){
        echo "<script>showMessage('" . $message . "');</script>";
      } 
    ?>
    
    <!-- Page specific script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
          {
            ranges   : {
              'Today'       : [moment(), moment()],
              'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month'  : [moment().startOf('month'), moment().endOf('month')],
              'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
          },
          function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function(){
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

      })
      // BS-Stepper Init
      /*document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })

      // DropzoneJS Demo Code Start
    /* Dropzone.autoDiscover = false

      // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
      var previewNode = document.querySelector("#template")
      previewNode.id = ""
      var previewTemplate = previewNode.parentNode.innerHTML
      previewNode.parentNode.removeChild(previewNode)

      var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
      })

      myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
      })

      // Update the total progress bar
      myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
      })

      myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
      })

      // Hide the total progress bar when nothing's uploading anymore
      myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
      })

      // Setup the buttons for all transfers
      // The "add files" button doesn't need to be setup because the config
      // `clickable` has already been specified.
      document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
      }
      document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
      } */
      // DropzoneJS Demo Code End 
    </script>
  </body>
</html>