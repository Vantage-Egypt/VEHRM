<?php 
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


function fetchEmployeeRecordsFromDatabase($conn, $tmonthCode, $tweekCode) {
    $employeeRows = array();

    $query = "SELECT * FROM tblattendance WHERE tmonth = '$tmonthCode' AND tweek = '$tweekCode'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $employeeRows[] = $row;
        }
    }

    return $employeeRows;
}

$tmonthCode = isset($_GET['tmonth']) ? $_GET['tmonth'] : '';
$tweekCode = isset($_GET['tweek']) ? $_GET['tweek'] : '';

$employeeRows = fetchEmployeeRecordsFromDatabase($conn, $tmonthCode, $tweekCode);

$tmonthname = "";
if (!empty($tmonthCode)) {
    $tmonthname_query = "SELECT name FROM tbltmonth WHERE tmonthCode = '$tmonthCode'";
    $result = mysqli_query($conn, $tmonthname_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tmonthname = $row['name'];
    }
}
$tweekname="";
if (!empty($tweekCode)) {
    $tweekname_query = "SELECT name FROM tbltweek WHERE tweekCode = '$tweekCode'";
    $result = mysqli_query($conn, $tweekname_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tweekname = $row['name'];
    }
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
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>



<body>
<?php include 'includes/topbar.php';?>
    <section class="main">
        <?php include 'includes/sidebar.php';?>
    <div class="main--content">
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
    </form>


    <div class="table-container">
    <div class="title">
        <h2 class="section--title">Employees List</h2>
    </div>
    <div class="table attendance-table" id="attendaceTable">
        <table>
        <thead>
                <tr>
                    <th>Registration No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>

                </tr>
            </thead>
            <tbody>
      <?php  $query = "SELECT * FROM tblemployees WHERE tmonthCode = '$tmonthCode'";

          $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['registrationNumber'] . "</td>";
        echo "<td>" . $row['firstName'] . "</td>";
        echo "<td>" . $row['lastName'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";

        echo "</tr>";
    }
    
    echo "</table>";
} else {
}
?>

            </tbody>
        </table>
        
    </div>
</div>

            </div>
</div>
</section>
<div>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/table-to-excel/dist/tableToExcel.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script  src="../admin/javascript/main.js"></script>


<script>
function updateTable(){
    var tmonthSelect = document.getElementById("tmonthSelect");
    var tweekSelect = document.getElementById("tweekSelect");
    
    var selectedTMonth = tmonthSelect.value;
    var selectedTWeek = tweekSelect.value;
    
    var url = "viewEmployees.php";
    if (selectedTMonth && selectedTWeek) {
        url += "?tmonth=" + encodeURIComponent(selectedTMonth) + "&tweek=" + encodeURIComponent(selectedTWeek);
        window.location.href = url;

    }}

</script>

</html>