<?php 
    session_start();
  $con=mysqli_connect('localhost','root');
    
  mysqli_select_db($con,'php_assignment');
  $fnameErr = $lnameErr = $genderErr = $emailErr = $mobileErr = $passwordErr = $cpasswordErr = "";
  $fname = $lname = $gender = $email = $mobile = $password = $cpassword = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["fname"]))) {
        $fnameErr = " First name is required";
    } else {
        $fname = $_POST["fname"];
    }

    if (empty(trim($_POST["lname"]))) {
        $lnameErr = "Last name is required";
    } else {
        $lname = $_POST["lname"];
    }

    if (empty(trim($_POST["gender"]))) {
        $genderErr = "Gender is required";
    } else {
        $gender = $_POST["gender"];
    }

    if (empty(trim($_POST["email"]))) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }
        
    if (empty(trim($_POST["mobile"]))) {
        $mobileErr = "Mobile is required";
    } else {
        $mobile = $_POST["mobile"];
        if(strlen($mobile)<10 or !preg_match ("/^[0-9]*$/", $mobile))
        {
            $mobileErr = "Invalid Mobile Number";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty(trim($_POST["cpassword"]))) {
        $cpasswordErr = "Confirm Password is required";
    } else {
        $cpassword = $_POST["cpassword"];
    }
}
    $sql="select * from users where EmailId='$email' OR MobileNo='$mobile'";
    $result=mysqli_query($con,$sql);
    $num=mysqli_num_rows($result);
    if(!empty($email))
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $emailErr = "Invalid Email Id!";
      }
      else if($num==0){
        if(!empty($password) and !empty($mobile)){
            if ($password != $cpassword) {
                $cpasswordErr = "Passwords do not match";
            }
            else{
                $q = "insert into users(FirstName,LastName,Gender,EmailId,MobileNo,Password) values ('$fname','$lname','$gender','$email','$mobile','$password')";
                $result = mysqli_query($con,$q);
                if($result)
                {
                    $_SESSION["name"] = $fname." ".$lname;
                    $_SESSION["email"] = $email;
                    $_SESSION["gender"] = $gender;
                    $_SESSION["mobile"] = $mobile;
                }
                header("location:profile.php");
            }
        }
      }
      else{
        echo "data already exists";
      }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registration page</title>
        <link rel = "stylesheet" type="text/css" href="styles/style1.css">
    </head>
    <body>
        <div class="flex-container">
            <h1>Register Now</h1>
            <form name="RegistrationForm" method="POST">
                <input type="text" value="<?php echo $fname?>" name="fname" placeholder ="First Name">
                <span class="error">* <?php echo $fnameErr;?></span>
                <input type="text" value="<?php echo $lname?>" name="lname" placeholder ="Last Name">
                <span class="error">* <?php echo $lnameErr;?></span>
                <select name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option <?php if (isset($gender) && $gender=="Male") echo "selected";?> value="Male">Male</option>
                    <option <?php if (isset($gender) && $gender=="Female") echo "selected";?> value="Female">Female</option>
                    <option <?php if (isset($gender) && $gender=="Other") echo "selected";?> value="Other">Other</option>
                </select>
                <span class="error">* <?php echo $genderErr;?></span>
                <input type="text" value="<?php echo $email?>" name="email" placeholder="Email">
                <span class="error">* <?php echo $emailErr;?></span>
                <input type="text" value="<?php echo $mobile?>" name="mobile" placeholder="Mobile No.">
                <span class="error">* <?php echo $mobileErr;?></span>
                <input type="password" name="password" placeholder="Password">
                <span class="error">* <?php echo $passwordErr;?></span>
                <input type="password" name="cpassword" placeholder="Confirm Password">
                <span class="error">* <?php echo $cpasswordErr;?></span>
                <input type="submit" value="Register" id="button">
            </form>
        </div>
    </body>
</html>