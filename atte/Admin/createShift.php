<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getBranchNames($conn) {
    $sql = "SELECT branchCode, branchName FROM tblbranch";
    $result = $conn->query($sql);

    $branchNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $branchNames[] = $row;
        }
    }

    return $branchNames;
}
if (isset($_POST["addShift"])) {
    $className = $_POST["className"];
    $branchCode = $_POST["branch"];
    $currentStatus = $_POST["currentStatus"];
    $capacity=$_POST["capacity"];
    
    $branch=$_POST["branch"];
    $dateRegistered = date("Y-m-d H:i");

    $query=mysqli_query($conn,"select * from tblshift where className='$className'");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = " TimeShift Already Exists";
    }
    else{
            $query=mysqli_query($conn,"insert into tblshift(className,branchCode,currentStatus,capacity,dateCreated) 
        value('$className','$branchCode','$currentStatus','$capacity','$dateRegistered')");
        $message = " TimeShift Inserted Successfully";

    }
   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/topbar.php'?>
<section class="main">
<?php include 'includes/sidebar.php';?>
 <div class="main--content">

 <div id="overlay"></div>

 <div class="rooms">
                <div class="title">
                    <h2 class="section--title">Shift</h2>
                    <div class="rooms--right--btns">
                        <select name="date" id="date" class="dropdown room--filter">
                            <option >Filter</option>
                            <option value="Morning">Morning</option>
                            <option value="Night">Night</option>
                        </select>
                        <button id="addClass1" class="add"><i class="ri-add-line"></i>Add New TimeShift</button>
                    </div>
                </div>
                <div class="rooms--cards">
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/office image.jpeg" alt="">
                            </div>
                        </div>
                        <p class="Morning">Morning</p>
                    </a>
                    <a href="#" class="room--card">
                        <div class="img--box--cover">
                            <div class="img--box">
                            <img src="img/class.jpeg" alt="">
                            </div>
                        </div>
                        <p class="Night">Night</p>
                    </a>
                    
                   
                   
                  
                   
                </div>
            </div>
            <div id="messageDiv" class="messageDiv" style="display:none;"></div>

            <div class="table-container">
            <div class="title" id="addClass2">
                    <h2 class="section--title">Manage Shift</h2>
                    <button class="add"><i class="ri-add-line"></i>Add Shift</button>
                </div>
        
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>TimeShift Name</th>
                                <th>Branch</th>
                                <th>Current Status</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tblshift";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["className"] . "</td>";
                            echo "<td>" . $row["branchCode"] . "</td>";
                            echo "<td>" . $row["currentStatus"] . "</td>";
                            
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    ?>  
                        </tbody>
                    </table>
                </div>
                
            </div>
                
<div class="formDiv-shift" id="addClassForm"  style="display:none; ">
<form method="POST" action="" name="addShift" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Add TimeShift</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>
    <input type="text" name="className" placeholder="Shift Type" required>
    <select name="currentStatus" id="">
        <option value="">--Current Status--</option>
        <option value="Morning">Morning</option>
        <option value="Night">Night</option>
    </select>
    <input type="text" name="capacity" placeholder="Capacity" required>
    
    <select required name="branch">
        <option value="" selected>Select Branch</option>
        <?php
        $branchNames = getBranchNames($conn);
        foreach ($branchNames as $branch) {
            echo '<option value="' . $branch["branchCode"] . '">' . $branch["branchName"] . '</option>';
        }
        ?>
    </select>
    <input type="submit" class="submit" value="Save Shift" name="addShift">
</form>		  
</div>
 </div>
</section>
<script src="javascript/main.js"></script>
<script src="./javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
<script>
   
const addClass1 = document.getElementById('addClass1');
const addClass2 = document.getElementById('addClass2');
const addClassForm = document.getElementById('addClassForm');
const overlay = document.getElementById('overlay'); // Add this line to select the overlay element

addClass1.addEventListener('click', function () {
    addClassForm.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 

});

addClass2.addEventListener('click', function () {
    addClassForm.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 

});

var closeButtons = document.querySelectorAll('#addClassForm .close');

closeButtons.forEach(function (closeButton) {
    closeButton.addEventListener('click', function () {
        addClassForm.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto'; 

    });
});

</script>
</body>
</html>