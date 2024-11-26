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
  <title>Managers Dashboard</title>
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

    <button class="add" onclick="exportTableToExcel('attendaceTable', '<?php echo $tweekCode ?>_on_<?php echo date('Y-m-d'); ?>','<?php echo $tmonthname ?>', '<?php  echo $tweekname ?>')">Export Attendance As Excel</button>

    <div class="table-container">
    <div class="title">
        <h2 class="section--title">Attendance Preview</h2>
    </div>
    <div class="table attendance-table" id="attendaceTable">
        <table>
            <thead>
                <tr>
                    <th>Registration No</th>
                    <?php
                    $distinctDatesQuery = "SELECT DISTINCT dateMarked FROM tblattendance where tmonth='$tmonthCode' and tweek='$tweekCode'";
                    $distinctDatesResult = mysqli_query($conn, $distinctDatesQuery);

                    if ($distinctDatesResult) {
                        while ($dateRow = mysqli_fetch_assoc($distinctDatesResult)) {
                            echo "<th>" . $dateRow['dateMarked'] . "</th>";
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($employeeRows as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["employeeRegistrationNumber"] . "</td>";
                    $distinctDatesResult = mysqli_query($conn, $distinctDatesQuery);
                    if ($distinctDatesResult) {
                        while ($dateRow = mysqli_fetch_assoc($distinctDatesResult)) {
                            $date = $dateRow['dateMarked'];
                            $attendanceQuery = "SELECT attendanceStatus FROM tblattendance WHERE employeeRegistrationNumber = '" . $row['employeeRegistrationNumber'] . "' AND dateMarked = '$date'";
                            $attendanceResult = mysqli_query($conn, $attendanceQuery);
                            
                            if ($attendanceResult && mysqli_num_rows($attendanceResult) > 0) {
                                $attendanceData = mysqli_fetch_assoc($attendanceResult);
                                echo "<td>" . $attendanceData['attendanceStatus'] . "</td>";
                            } else {
                                echo "<td>Absent</td>";
                            }
                        }
                    }
                    
                    echo "</tr>";
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

<script src="./min/js/filesaver.js"></script>
<script src="./min/js/xlsx.js"></script>
<script  src="../admin/javascript/main.js"></script>


<script>
function updateTable(){
    var tmonthSelect = document.getElementById("tmonthSelect");
    var tweekSelect = document.getElementById("tweekSelect");
    
    var selectedTMonth = tmonthSelect.value;
    var selectedTWeek = tweekSelect.value;
    
    var url = "downloadrecord.php";
    if (selectedTMonth && selectedTWeek) {
        url += "?tmonth=" + encodeURIComponent(selectedTMonth) + "&tweek=" + encodeURIComponent(selectedTWeek);
        window.location.href = url;

    }}
    function exportTableToExcel(tableId, filename = '', tmonthCode = '', tweekCode = '') {
    var table = document.getElementById(tableId);
    var currentDate = new Date();
    var formattedDate = currentDate.toLocaleDateString(); // Format the date as needed

    var headerContent = '<p style="font-weight:700;"> Attendance for : ' + tmonthCode + ' tweek name : ' + tweekCode + ' On: ' + formattedDate + '</p>';
    var tbody = document.createElement('tbody');
    var additionalRow = tbody.insertRow(0);
    var additionalCell = additionalRow.insertCell(0);
    additionalCell.innerHTML = headerContent;
    table.insertBefore(tbody, table.firstChild);
    var wb = XLSX.utils.table_to_book(table, { sheet: "Attendance" });
    var wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });
    var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
    if (!filename.toLowerCase().endsWith('.xlsx')) {
        filename += '.xlsx'; 
    }

    saveAs(blob, filename);
}

function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}




</script>

</html>