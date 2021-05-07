<?php 
  session_start();
  $con=mysqli_connect('localhost','root');
  mysqli_select_db($con,'php_assignment');
  $emailErr = $passwordErr = "";
  $email = $password = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
      $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }
  }

  $sql="select * from users where EmailId='$email' and Password='$password' ";
    
  $result=mysqli_query($con,$sql);
  if(!empty($email))
  {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $emailErr="Invalid Email Id!";

    }
    else if(mysqli_num_rows($result)==1)
    {
        while($row = $result->fetch_assoc()){
            $_SESSION["name"] = $row["FirstName"]." ".$row["LastName"];
            $_SESSION["email"] = $row["EmailId"];
            $_SESSION["gender"] = $row["Gender"];
            $_SESSION["mobile"] = $row["MobileNo"];
        }
        header("location:http://localhost/cwh/profile.php");
    }
    else if (!empty($password)){
        echo "<center><b>User Not Found</b></center>";
    }
  }
  

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel = "stylesheet" type="text/css" href="styles/login.css">
        <style>
          .error{color:red;}
        </style>
    </head>
    <body>
      <div class="flex-container">
         <h1>Welcome Page</h1>
         <form name="LoginForm" method="POST">
            <input type="text" value="<?php echo $email?>" name="email" placeholder="Email">
            <span class="error">* <?php echo $emailErr;?></span>
            <input type="password" name="password" placeholder="Password">
            <span class="error">* <?php echo $passwordErr;?></span>
            <input type="submit" id="button" value="Login">
            <button type="button" onclick="" id="button"><a href="registration.php">Register</a></button>
         </form>
      </div>
    </body>
</html>