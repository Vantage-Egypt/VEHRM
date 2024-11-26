<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

function getBranchNames($conn) {
    $sql = "SELECT Id, branchName FROM tblbranch";
    $result = $conn->query($sql);

    $branchNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $branchNames[] = $row;
        }
    }

    return $branchNames;
}
function getManagerNames($conn) {
    $sql = "SELECT Id, firstName, lastName FROM tblmanager";
    $result = $conn->query($sql);

    $managerNames = array();  
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $managerNames[] = $row;
        }
    }

    return $managerNames;
}
function getTMonthNames($conn) {
    $sql = "SELECT ID,name FROM tbltmonth";
    $result = $conn->query($sql);

    $tmonthNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmonthNames[] = $row;
        }
    }

    return $tmonthNames;
}

    if (isset($_POST["addTMonth"])) {
        $tmonthName = $_POST["tmonthName"];
        $tmonthCode = $_POST["tmonthCode"];
        $branchID = $_POST["branch"];
        $dateRegistered = date("Y-m-d H:i");

        $query=mysqli_query($conn,"select * from tbltmonth where tmonthCode='$tmonthCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 
                $message = " Month Already Exists";
        }
        else{
                $query=mysqli_query($conn,"insert into tbltmonth(name,tmonthCode,branchID,dateCreated) 
            value('$tmonthName','$tmonthCode','$branchID','$dateRegistered')");
            $message = " Month Inserted Successfully";

        }
       
    }
    if (isset($_POST["addTWeek"])) {
        $tweekName = $_POST["tweekName"];
        $tweekCode = $_POST["tweekCode"];
        $tmonthID = $_POST["tmonth"];
        $dateRegistered = date("Y-m-d H:i");

        $query=mysqli_query($conn,"select * from tbltweek where tweekCode='$tweekCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 
                $message = " Week Already Exists";

        }
        else{
            $query=mysqli_query($conn,"insert into tbltweek(name,tweekCode,tmonthID,dateCreated) 
            value('$tweekName','$tweekCode','$tmonthID','$dateRegistered')");
            $message = " Week Inserted Successfully";

        }
       
    
       
    }
    if (isset($_POST["addBranch"])) {
        $branchName = $_POST["branchName"];
        $branchCode = $_POST["branchCode"];
        $dateRegistered = date("Y-m-d H:i");

        $query=mysqli_query($conn,"select * from tblbranch where branchCode='$branchCode'");
        $ret=mysqli_fetch_array($query);
            if($ret > 0){ 

                $message = " branch already Exists";}
        else{
            $query=mysqli_query($conn,"insert into tblbranch(branchName,branchCode,dateRegistered) 
            value('$branchName','$branchCode','$dateRegistered')");
            $message = " branch Inserted Successfully";

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
 <script src="./javascript/confirmation.js" defer></script>
</head>
<body>
<?php include 'includes/topbar.php'?>
<section class="main">
<?php include 'includes/sidebar.php';?>
 <div class="main--content">
    <div id="overlay"></div>
 <div class="overview">
                <div class="title">
                    <h2 class="section--title">Overview</h2>
                    <select name="date" id="date" class="dropdown">
                        <option value="today">Today</option>
                        <option value="lasttweek">Last Week</option>
                        <option value="lasttmonth">Last Month</option>
                        <option value="lastyear">Last Year</option>
                        <option value="alltime">All Time</option>
                    </select>
                </div>
                <div class="cards">
                    <div id="addTMonth" class="card card-1">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tbltmonth");                       
                        $tmonths = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Add Month</button>
                                <h1><?php echo $tmonths;?> Months</h1>
                            </div>
                            <i class="ri-user-2-line card--icon--lg"></i>
                        </div>
                       
                    </div>
                    <div class="card card-1" id="addTWeek">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tbltweek");                       
                        $tweek = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data" >
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Add New Week</button>
                                <h1><?php echo $tweek;?> Weeks</h1>
                            </div>
                            <i class="ri-file-text-line card--icon--lg"></i>
                        </div>
                        
                    </div>
                   
                    <div class="card card-1" id="addBranch">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblbranch");                       
                        $branch = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                            <button class="add"><i class="ri-add-line"></i>Add branch</button>
                                <h1><?php echo $branch;?> branches </h1> 
                            </div>
                            <i class="ri-user-line card--icon--lg"></i>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div id="messageDiv" class="messageDiv" style="display:none;"></div>

            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">Month</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Month Name</th>
                                <th>branch Name</th>
                                <th>Total Weeks</th>
                                <th>Total Employees</th>
                                <th>Date Created</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT 
                        c.name AS tmonth_name,
                        c.branchID AS branch,
                        f.branchName AS branch_name,
                        COUNT(u.ID) AS total_TWeeks,
                        COUNT(DISTINCT s.Id) AS total_employees,
                        c.dateCreated AS date_created
                        FROM tbltmonth c
                        LEFT JOIN tbltweek u ON c.ID = u.tmonthID
                        LEFT JOIN tblemployees s ON c.tmonthCode = s.tmonthCode
                        LEFT JOIN tblbranch f on c.branchID=f.Id
                        GROUP BY c.ID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["tmonth_name"] . "</td>";
                            echo "<td>" . $row["branch_name"] . "</td>";
                            echo "<td>" . $row["total_TWeeks"] . "</td>";
                            echo "<td>" . $row["total_employees"] . "</td>";
                            echo "<td>" . $row["date_created"] . "</td>";
                            
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
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">Week</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Week Code</th>
                                <th>Week Name</th>
                                <th>Month Name</th>
                                <th>Total Employees</th>
                                <th>Date Created</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT 
                            c.name AS tmonth_name,
                            u.tweekCode AS tweek_code,
                            u.name AS tweek_name,
                            u.dateCreated AS date_created,
                            COUNT(s.Id) AS total_employees
                            FROM tbltweek u
                            LEFT JOIN tbltmonth c ON u.tmonthID = c.ID
                            LEFT JOIN tblemployees s ON c.tmonthCode = s.tmonthCode
                            GROUP BY u.ID";                       
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["tweek_code"] . "</td>";
                            echo "<td>" . $row["tweek_name"] . "</td>";
                            echo "<td>" . $row["tmonth_name"] . "</td>";
                            echo "<td>" . $row["total_employees"] . "</td>";
                            echo "<td>" . $row["date_created"] . "</td>";
                            
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
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">branch</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>branch Code</th>
                                <th>branch Name</th>
                                <th>Total Months</th>
                                <th>Total Employees</th>
                                <th>Total Managers</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT 
                           f.branchName AS branch_name,
                           f.branchCode AS branch_code,
                           f.dateRegistered AS date_created,
                           COUNT(DISTINCT c.ID) AS total_tmonths,
                           COUNT(DISTINCT s.Id) AS total_employees,
                           COUNT(DISTINCT l.Id) AS total_managers
                       FROM tblbranch f
                       LEFT JOIN tbltmonth c ON f.Id = c.branchID
                       LEFT JOIN tblemployees s ON f.branchCode = s.branch
                       LEFT JOIN tblmanager l ON f.branchCode = l.branchCode
                       GROUP BY f.Id";
                                     
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                           while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["branch_code"] . "</td>";
                            echo "<td>" . $row["branch_name"] . "</td>";
                            echo "<td>" . $row["total_tmonths"] . "</td>";
                            echo "<td>" . $row["total_employees"] . "</td>";
                            echo "<td>" . $row["total_managers"] . "</td>";
                            echo "<td>" . $row["date_created"] . "</td>";
                            
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
 
 </div>
 <div class="formDiv" id="addTMonthForm"  style="display:none; ">
        
<form method="POST" action="" name="addTMonth" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Add New Month</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>

    <input type="text" name="tmonthName" placeholder="Month Name" required>
    <input type="text" name="tmonthCode" placeholder="Month Code" required>


    <select required name="branch">
        <option value="" selected>Select branch</option>
        <?php
        $branchNames = getBranchNames($conn);
        foreach ($branchNames as $branch) {
            echo '<option value="' . $branch["Id"] . '">' . $branch["branchName"] . '</option>';
        }
        ?>
    </select>

    <input type="submit" class="submit" value="Save Month" name="addTMonth">
</form>		  
    </div>

<div class="formDiv" id="addTWeekForm"  style="display:none; ">
<form method="POST" action="" name="addTWeek" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Add New Week</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>

    <input type="text" name="tweekName" placeholder="Week Name" required>
    <input type="text" name="tweekCode" placeholder="Week Code" required>

    <select required name="manager">
        <option value="" selected>Assign Manager</option>
        <?php
        $managerNames = getManagerNames($conn);
        foreach ($managerNames as $manager) {
            echo '<option value="' . $manager["Id"] . '">' . $manager["firstName"] . ' ' . $manager["lastName"]  .  '</option>';
        }
        ?>
    </select>
    <select required name="tmonth">
        <option value="" selected>Select Month</option>
        <?php
        $tmonthNames = getTMonthNames($conn);
        foreach ($tmonthNames as $tmonth) {
            echo '<option value="' . $tmonth["ID"] . '">' . $tmonth["name"] . '</option>';
        }
        ?>
    </select>

    <input type="submit" class="submit" value="Save Week" name="addTWeek">
</form>		  
 </div>
    
<div class="formDiv" id="addBranchForm"  style="display:none; ">
<form method="POST" action="" name="addbranch" enctype="multipart/form-data">
    <div style="display:flex; justify-content:space-around;">
        <div class="form-title">
            <p>Add New branch</p>
        </div>
        <div>
            <span class="close">&times;</span>
        </div>
    </div>
    <input type="text" name="branchName" placeholder="branch Name" required>
    <input type="text" name="branchCode" placeholder="branch Code" required>
    <input type="submit" class="submit" value="Save branch" name="addbranch">
</form>		  
</div>
      
      

</section>
<script src="javascript/main.js"></script>
<script src="javascript/addMonth.js"></script>
<script src="javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
</body>
</html>


        
      
