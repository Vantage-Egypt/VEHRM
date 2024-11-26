<?php 
include 'Includes/dbcon.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en" >
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link href="admin/img/logo/attnlg.png" rel="icon">
      <title>VantageEgypt Face Attendance System Login</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="css/myloginstyle.css">

  </head>
<body>
  <!-- partial:index.partial.html -->
  <div class="container" id="container">
      <div class="form-container sign-in-container">
          <form method="post" action="">
              <img src="./velogo.png" style="width:250px;">
              <select required name="userType">
                <option value="">--Select User Roles--</option>
                <option value="Administrator">Admin System</option>
                <option value="Manager">Manager</option>
              </select>
              <input type="username" name="email" placeholder="Type your email" />
              <input type="password" name="password" placeholder="Type your password" />
                <a href="#">Forgot your password Please Contact To System Admininstrator</a>
              <input type="submit" class="btn-login" value="Login" name="login" />

              <div id="messageDiv" class="messageDiv" style="display:none;"></div>
          </form>
          
      </div>
      <div class="overlay-container">
          <div class="overlay">
              <div class="overlay-panel overlay-right">
                  <h1>Login to Record your Attendance</h1>
                  <p>Vantage Egypt HRM System</p>
              </div>
          </div>
      </div>
  </div>
  <!-- partial -->


  <script>
    function showMessage(message) {
    var messageDiv = document.getElementById('messageDiv');
    messageDiv.style.display="block";
    messageDiv.innerHTML = message;
    messageDiv.style.opacity = 1;
    setTimeout(function() {
      messageDiv.style.opacity = 0;
    }, 5000);
  }
  </script>
  
<?php
  if(isset($_POST['login'])){

    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

  if($userType == "Administrator"){
    
      $query = "SELECT * FROM tbladmin WHERE emailAddress = '$email' and password='$password'  ";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
        window.location = (\"Admin/index.php\")
        </script>";
      }

      else{

        $message = " Invalid Username/Password!";
        echo "<script>showMessage('" . $message . "');</script>";

      }
    }
    else if($userType == "Manager"){

      $query = "SELECT * FROM tblmanager WHERE emailAddress = '$email' and password='$password' "; 
       
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userlogId'] = $rows['Id'];
       
        echo "<script type = \"text/javascript\">
        window.location = (\"Manager/takeAttendance.php\")
        </script>";
       
     
      
      }

      else{

        $message = " Invalid Username/Password!";
        echo "<script>showMessage('" . $message . "');</script>";

      }
    }
    else{

    
    

    }
}
?>

                                  
</body>
</html>