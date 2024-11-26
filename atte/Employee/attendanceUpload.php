<?php

include './includes/dbcon.php';

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
                echo "Attendance data for Employee ID $employeeID inserted successfully.<br>";
            } else {
                echo "Error inserting attendance data: " . $conn->error . "<br>";
            }
        }
    } else {
        echo "No attendance data received.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}

?>
