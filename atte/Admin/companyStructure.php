<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';

function getCompanies($conn) {
    $sql = "SELECT ComId,ComName FROM tblcompanystructure";
    $result = $conn->query($sql);

    $comNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comNames[] = $row;
        }
    }

    return $comNames;
}

function getUsers($conn) {
  $sql = "SELECT userlogId,userName FROM tblusers";
  $result = $conn->query($sql);

  $userNames = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $userNames[] = $row;
      }
  }

  return $userNames;
}

if(isset($_POST['saveCompany'])){
    $comId=$_POST['ComId'];
    $comName=$_POST['ComName'];
    $comType=$_POST['ComType'];
    $comEmail=$_POST['ComEmail'];
    $comParent=$_POST['ComParent'];
    $comManagers=$_POST['ComManagers'];
    $comAddress=$_POST['ComAddress'];
    $comDescription=$_POST['ComDescription'];
    $comDomain=$_POST['ComDomain'];
    $dateRegistered = date("Y-m-d");
    $query=mysqli_query($conn,"SELECT * FROM tblcompanystructure where ComId ='$comId'");
    $ret=mysqli_fetch_array($query);
  
        if($ret > 0){ 
            $message = "Company with the give Company ID: $comId Exists!";
    }
    else{
            $query=mysqli_query($conn,"INSERT INTO tblcompanystructure(ComId,ComName,ComType,ComEmail,ComParent,ComManagers,ComAddress,ComDescription,ComDomain,dateRegistered) 
            value('$comId','$comName','$comType','$comEmail','$comParent','$comManagers','$comAddress','$comDescription','$comDomain','$dateRegistered')");
            $message = " Company : $comName Added Successfully";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company Structure</title>
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
              <h1 class="m-0">Company Structure</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../Admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">CompanyStructure</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

                <section class="content">
                  <div id="overlay"></div>
                  <div id="messageDiv" class="messageDiv" style="display:none;"></div>
                  <div class="container-fluid">
                    
                    <div class="row">
                      <div class="card" style="width:100%;">
                        <div class="card-header border-transparent">
                          <div class="title" id="saveCompany">
                              <button class="add"><i class="fas fa-plus"></i>Add New Company</button>
                          </div>
                          <!-- card Body -->
                          <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                  <th style="width:50px;">ID</th>
                                  <th style="width:120px;">Name</th>
                                  <th style="width:100px;">Type</th>
                                  <th style="width:250px;">Email</th>
                                  <th style="width:120px;">Parent</th>
                                  <th style="width:50px;">Managers</th>
                                  <th>Address</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $sql = "SELECT * FROM tblcompanystructure";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                      echo "<tr>";
                                      echo "<td>" . $row["ComId"] . "</td>";
                                      echo "<td>" . $row["ComName"] . "</td>";
                                      echo "<td>" . $row["ComType"] . "</td>";
                                      echo "<td>" . $row["ComEmail"] . "</td>";
                                      echo "<td>" . $row["ComParent"] . "</td>";
                                      echo "<td>" . $row["ComManagers"] . "</td>";
                                      echo "<td>" . $row["ComAddress"] . "</td>";
                                      
                                      
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
                          <div class="formDiv--" id="addCompanyForm" style="display:none;"> 
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
                                        <label>ID</label>
                                        <input required type="text" class="form-control" name="ComId" value="<?php echo $row['ComId'];?>" placeholder="Enter ID">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Name</label>
                                        <input required type="text" class="form-control" name="ComName" value="<?php echo $row['ComName'];?>" placeholder="Enter Name">
                                      </div>

                                      <div class="form-group">
                                        <label>Type</label>
                                        <select required name="ComType" class="form-control select2" style="width: 70%;">
                                          <option selected="selected">Branch</option>
                                          <option>Company</option>
                                          <option>Head Office</option>
                                          <option>Department</option>
                                          <option>Brand</option>
                                          <option>Regional Office</option>
                                          <option>Store</option>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width:70%;">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="ComEmail" value="<?php echo $row['ComEmail'];?>" placeholder="Enter Email">
                                      </div>

                                      <div class="form-group">
                                        <label>Parent</label>
                                        <select name="ComParent" class="form-control select2" style="width: 70%;">
                                          <option value="" selected>Select Type</option>
                                            <?php
                                              $comNames = getCompanies($conn);
                                              foreach ($comNames as $Parent) {
                                                echo '<option value="' . $Parent["ComName"] . '">' . $Parent["ComName"] . '</option>';
                                              }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-group" style="width:100%;">
                                        <label>Managers</label>
                                        <select name="ComManagers" class="select2" multiple="multiple" data-placeholder="Select Manager" style="width: 70%;">
                                          <option>
                                          <?php
                                          $userNames = getUsers($conn);
                                          foreach ($userNames as $Manager) {
                                            echo '<option value="' . $Manager["userName"] . '">' . $Manager["userName"] . '</option>';
                                          }
                                          ?>
                                          </option>
                                        </select>
                                      </div>


                                      <div class="form-group" style="width:70%;">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="ComAddress" value="<?php echo $row['ComAddress'];?>" placeholder="Enter Address">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="ComDescription" value="<?php echo $row['ComDescription'];?>" placeholder="Enter Description">
                                      </div>
                                      <div class="form-group" style="width:70%;">
                                        <label>Domain Name</label>
                                        <input type="text" class="form-control" name="ComDomain" value="<?php echo $row['ComDomain'];?>" placeholder="Enter Domain">
                                      </div>
                                    </div>

                                    <!-- card-body 2 --> 
                                    <div class="card-header" style="margin-bottom: 50px;">
                                      <h3 class="card-title">Documents</h3>
                                    </div>
                                    <div class="card-body">
                                      <div class="form-group" style="width:70%;">
                                        <label for="InputFile">File input</label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="InputFile">
                                            <label class="custom-file-label" for="InputFile">Choose file</label>
                                          </div>
                                          <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                          </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                      <button type="submit" class="btn btn-primary" value="Save Company" name="saveCompany">Save</button>
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
    <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>VE HRM System</b>
    </div>
    Copyright &copy; 2024-2025 <a href="#">VE IT Team</a>. All rights reserved.
  </footer>

    <!-- Script open Input Form -->
    <script>
        const saveCompany=document.getElementById('saveCompany');
        const addCompanyForm=document.getElementById("addCompanyForm");
        saveCompany.addEventListener("click",function(){
            addCompanyForm.style.display = "block";
            overlay.style.display="block";
            addCompanyForm.style.overflowY = 'scroll'; 
            document.body.style.overflow = 'hidden'; 

        
        })
        var closeButtons = document.querySelectorAll(' #addCompanyForm .close');
        
        closeButtons.forEach(function(closeButton) {
            closeButton.addEventListener('click', function() {
                addCompanyForm.style.display="none";
                overlay.style.display = 'none';
                document.body.style.overflow = 'auto'; 
            });
        });
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
    <?php
      if(isset($message)){
        echo "<script>showMessage('" . $message . "');</script>";
      } 
    ?>
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