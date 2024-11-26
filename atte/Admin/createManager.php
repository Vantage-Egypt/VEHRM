<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


error_reporting(0);
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


if (isset($_POST["addManager"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber= $_POST["phoneNumber"];
    $branch = $_POST["branch"];
    $dateRegistered = date("Y-m-d H:i");
    $password="password";
    $password = md5($password);

    $query=mysqli_query($conn,"select * from tblmanager where emailAddress='$email'");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = " Manager Already Exists";
        }
    else{
            $query=mysqli_query($conn,"insert into tblmanager(firstName,lastName,emailAddress,password,phoneNo,branchCode,dateCreated) 
        value('$firstName','$lastName','$email','$password','$phoneNumber','$branch','$dateRegistered')");
        $message = " Manager Added Successfully";

    }
   
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">

   <title>Admin Dashboard</title>
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
   <script src="javascript/addEmployee.js"></script>   
   <script src="../Manager/face-api.min.js"></script>
</head>
<body>
<?php include "Includes/topbar.php";?>

  <section class=main>
      
      <?php include "Includes/sidebar.php";?>
       
   <div class="main--content"> 
   <div id="overlay"></div>
   <div id="messageDiv" class="messageDiv" style="display:none;"></div>

   <div class="table-container">
            <a href="#add-form" style="text-decoration:none;"> <div class="title" id="addManager">
                    <h2 class="section--title">Managers</h2>
                    <button class="add"><i class="ri-add-line"></i>Add Manager</button>
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Manager Name</th>
                                <th>Email Address</th>
                                <th>Phone No</th>
                                <th>Branch Name</th>
                                <th>Date Registered</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                        <?php
                        $sql = "SELECT * FROM tblmanager";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["firstName"] . "</td>";
                            echo "<td>" . $row["emailAddress"] . "</td>";
                            echo "<td>" . $row["phoneNo"] . "</td>";
                            echo "<td>" . $row["branchCode"] . "</td>";
                            echo "<td>" . $row["dateCreated"] . "</td>";
                            
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
<div id="addManagerForm"  style="display:none; ">
    <form method="POST" action="" name="addmanager" enctype="multipart/form-data">
        <div style="display:flex; justify-content:space-around;">
            <div class="form-title">
            <p>Add New Manager</p>
            </div>
        <div>
            <span class="close">&times;</span>
        </div>
        </div>
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phoneNumber" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="**********" required>

        <select required name="branch">
        <option value="" selected>Select Branch</option>
        <?php
        $branchNames = getBranchNames($conn);
        foreach ($branchNames as $branch) {
            echo '<option value="' . $branch["branchCode"] . '">' . $branch["branchName"] . '</option>';
        }
        ?>
    </select>
        <input type="submit" class="submit" value="Save Manager" name="addmanager">
    </form>		  
</div>
      
                   
                  
 </section>

 <script src="javascript/main.js"></script>
<script src="javascript/addManager.js"></script>
<script src="./javascript/confirmation.js"></script>

<script>
    
</script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
</body>

</html>