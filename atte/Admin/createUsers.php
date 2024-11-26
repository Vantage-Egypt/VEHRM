<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';

function getCompanies($conn) {
  $sql = "SELECT ComName FROM tblcompanystructure";
  $result = $conn->query($sql);

  $companytNames = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $companytNames[] = $row;
      }
  }

  return $companytNames;
}

function getEmployees($conn) {
  $sql = "SELECT empId,empFullname FROM tblemployees";
  $result = $conn->query($sql);
  $employeeNames = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $employeeNames[] = $row;
      }
  }

  return $employeeNames;
}


if(isset($_POST['saveUser'])){
    $userlogId=$_POST['userlogId'];
    $userEmployee=$_POST['userEmployee'];
    $userName=$_POST['userName'];
    $userPassword=$_POST['userPassword'];
    $userType=$_POST['userType'];
    $userPermission=$_POST['userPermission'];
    $userImage=$_POST['userImage'];
    $userNote=$_POST['userNote'];
    $dateRegistered = date("Y-m-d H:i");
    $query=mysqli_query($conn,"SELECT * FROM tblusers where userName ='$userName'");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = "user with the give username : $userName Exists!";
        }
        else{
            $query=mysqli_query($conn,"INSERT INTO tblusers(userlogId,userEmployee,userName,userPassword,userType,userPermission,userImage,userNote,dateRegistered) 
            value('$userlogId','$userEmployee','$userName','$userPassword','$userType','$userPermission','$userImage','$userNote','$dateRegistered')");
            $message = " user : $userName Added Successfully";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="author" content="Mohamed Adel">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
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
              <h1 class="m-0">users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../Admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
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
                    <div class="row">
                      <div class="card" style="width:100%;">
                        <div class="card-header border-transparent">
                          <div class="title" id="saveUser">
                              <button class="add"><i class="fas fa-plus"></i>Add New user</button>
                          </div>
                          <!-- card Body -->
                          <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                  <th>User ID</th>
                                  <th>Employee</th>
                                  <th>Username</th>
                                  <th>User Level</th>
                                  <th>dateRegistered</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $sql = "SELECT * FROM tblusers";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["userlogId"] . "</td>";
                                        echo "<td>" . $row["userEmployee"] . "</td>";
                                        echo "<td>" . $row["userName"] . "</td>";
                                        echo "<td>" . $row["userType"] . "</td>";
                                        echo "<td>" . $row["dateRegistered"] . "</td>";
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
                          <div class="formDiv--" id="addUserForm" style="display:none;"> 
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
                                        <label>User ID</label>
                                        <input required type="text" class="form-control" name="userlogId" value="<?php echo $row['userlogId'];?>" placeholder="Enter ID">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Employee</label>
                                        <select name="userEmployee" class="form-control select2">
                                            <option selected>Select Employee</option>
                                            <?php
                                            $employeeNames = getEmployees($conn);
                                            foreach ($employeeNames as $Employee) {
                                                echo '<option value="' . $Employee["empFullname"] . '">' . $Employee["empFullname"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>UserName</label>
                                        <input required type="username" class="form-control" name="userName" value="<?php echo $row['userName'];?>" placeholder="Enter username">
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>Password</label>
                                        <input type="password" id="password" class="form-control" name="userPassword" value="<?php echo $row['userPassword'];?>" placeholder="Enter password">
                                        <input type="checkbox" style="width:auto;" onclick="ShowPass()"> Show Password
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>User Type</label>
                                        <select required name="userType" class="form-control select2" data-placeholder="Select User Type">
                                            <option selected="selected">System Admin</option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option>Employee</option>
                                            <option>Other</option>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>User Permissions</label>
                                        <select name="userPermission" class="select2" multiple="multiple" data-placeholder="Select Permission">
                                            <option>
                                            <?php
                                            $companyNames = getCompanies($conn);
                                            foreach ($companyNames as $Company) {
                                                echo '<option value="' . $Company["ComName"] . '">' . $Company["ComName"] . '</option>';
                                            }
                                            ?>
                                            </option>
                                        </select>
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>User Note</label>
                                        <input type="text" class="form-control" style="height:150px;" name="userNote" value="<?php echo $row['userNote'];?>" placeholder="Enter Notes">
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
                                            <input type="file" class="custom-file-input" id="InputFile" name="userImage">
                                            <label class="custom-file-label">Choose file</label>
                                          </div>
                                          <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                      <button type="submit" class="btn btn-primary" value="Save User" name="saveUser">Save</button>
                                    </div>   
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </section>
    </div>
    <!-- Script open Input Form -->
    <script>
        const saveUser=document.getElementById('saveUser');
        const addUserForm=document.getElementById("addUserForm");
        saveUser.addEventListener("click",function(){
            addUserForm.style.display = "block";
            overlay.style.display="block";
            addUserForm.style.overflowY = 'scroll'; 
            document.body.style.overflow = 'hidden'; 
            })
            var closeButtons = document.querySelectorAll(' #addUserForm .close');
        
            closeButtons.forEach(function(closeButton) {
                    closeButton.addEventListener('click', function() {
                    addUserForm.style.display="none";
                    overlay.style.display = 'none';
                    document.body.style.overflow = 'auto'; 
                });
            });
        function ShowPass() {
        var showPass = document.getElementById("password");
            if (showPass.type === "password") {
                showPass.type = "text";
            } else {
                    showPass.type = "password";
            }
        }     
    </script>

    <?php 
    if(isset($message)){
      echo "<script>showMessage('" . $message . "');</script>";
    } 
    ?>



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
    <!-- PAGE PLUGINS -->

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