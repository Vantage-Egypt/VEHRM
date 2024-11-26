<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Registration No</th>
                <th>Employee Name</th>
                <th>Month</th>
                <th>Week</th>
                <th>TimeShift</th>
                <th>Attendance</th>
                
            </tr>
        </thead>
        <tbody id="employeeTableContainer">
            <?php
            if (isset($_POST['tmonthID']) && isset($_POST['tweekID']) && isset($_POST['shiftID'])) {

                $tmonthID = $_POST['tmonthID'];
                $tweekID = $_POST['tweekID'];
                $shiftID = $_POST['shiftID'];

                $sql = "SELECT * FROM tblemployees WHERE tmonthCode = '$tmonthID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        $registrationNumber = $row["registrationNumber"];
                        echo "<td>" . $registrationNumber . "</td>";
                        echo "<td>" . $row["firstName"] . $row["lastName"] . "</td>";
                        echo "<td>" . $tmonthID . "</td>";
                        echo "<td>" . $tweekID . "</td>";
                        echo "<td>" . $shiftID . "</td>";
                        echo "<td>Absent</td>"; 
                        
                        echo "</tr>";
                    }

                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
