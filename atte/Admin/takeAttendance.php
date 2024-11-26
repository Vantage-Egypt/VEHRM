


<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getTMonthNames($conn) {
    $sql = "SELECT tmonthCode,name FROM tbltmonth";
    $result = $conn->query($sql);

    $tmonthNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmonthNames[] = $row;
        }
    }

    return $tmonthNames;
}
function getShiftNames($conn) {
    $sql = "SELECT className FROM tblshift";
    $result = $conn->query($sql);

    $shiftNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $shiftNames[] = $row;
        }
    }

    return $shiftNames;
}
function getTWeekNames($conn) {
    $sql = "SELECT tweekCode,name FROM tbltweek";
    $result = $conn->query($sql);

    $tweekNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tweekNames[] = $row;
        }
    }

    return $tweekNames;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendanceData = json_decode(file_get_contents("php://input"), true);

    if (!empty($attendanceData)) {
        foreach ($attendanceData as $data) {
            $employeeID = $data['employeeID'];
            $attendanceStatus = $data['attendanceStatus'];
            $tmonth = $data['tmonth'];
            $tweek = $data['tweek'];
            $date = date("Y-m-d H:i:s"); 

            $sql = "INSERT INTO tblattendance(employeeRegistrationNumber, tmonth, tweek, attendanceStatus, dateMarked)  
                    VALUES ('$employeeID', '$tmonth', '$tweek', '$attendanceStatus', '$date')";
            
            if ($conn->query($sql) === TRUE) {
                $message = " Attendance Recorded Successfully For $tmonth : $tweek on $date";
            } else {
                echo "Error inserting attendance data: " . $conn->error . "<br>";
            }
        }
    } else {
        echo "No attendance data received.<br>";
    }
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../admin/img/logo/attnlg.png" rel="icon">
  <title>Manager Dashboard</title>
  <link rel="stylesheet" href="../Manager/css/styles.css">
  <script defer src="../Manager/face-api.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>


<body>

<?php include 'includes/topbar.php';?>
    <section class="main">
        <?php include 'includes/sidebar.php';?>
    <div class="main--content">
    <div id="messageDiv" class="messageDiv"  style="display:none;" > </div>

    <form class="manager-options" id="selectForm">
    <select required name="tmonth" id="tmonthSelect"  onChange="updateTable()">
        <option value="" selected>Select Month</option>
        <?php
        $tmonthNames = getTMonthNames($conn);
        foreach ($tmonthNames as $tmonth) {
            echo '<option value="' . $tmonth["tmonthCode"] . '">' . $tmonth["name"] . '</option>';
        }
        ?>
    </select>

    <select required name="tweek" id="tweekSelect" onChange="updateTable()">
        <option value="" selected>Select Week</option>
        <?php
        $tweekNames = getTWeekNames($conn);
        foreach ($tweekNames as $tweek) {
            echo '<option value="' . $tweek["tweekCode"] . '">' . $tweek["name"] . '</option>';
        }
        ?>
    </select>
    
    <select required name="shift" id="shiftSelect" onChange="updateTable()">
        <option value="" selected>Select TimeShift</option>
        <?php
        $shiftNames = getShiftNames($conn);
        foreach ($shiftNames as $shift) {
            echo '<option value="' . $shift["className"] . '">' . $shift["className"] . '</option>';
        }
        ?>
    </select>
   
    </form>
    <div class="attendance-button">
      <button id="startButton" class="add" >Launch Face Recognition</button>
      <button id="endButton"class="add" style="display:none">End Attendance Process</button>
      <button id="endAttendance" class="add" >END Attendance Taking</button>
    </div>
   
    <div class="video-container" style="display:none;">
        <video  id="video" width="600" height="450" autoplay></video>
        <canvas id="overlay"></canvas>
    </div>

    <div class="table-container">

                <div id="employeeTableContainer" >
               

                    
                </div>
                
    </div>

</div>
</section>
    <script>

 </script>
   
<script  src="../Manager/script.js"></script>
<script  src="../admin/javascript/main.js"></script>





</body>
</html>