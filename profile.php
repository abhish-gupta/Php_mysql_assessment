<!DOCTYPE html>
<html>
    <head>
        <title>Profile Page</title>
        <link rel = "stylesheet" type="text/css" href="styles/profile.css">
    </head>
    <body>
        <button type="submit" id="button"><a href="contactUs.php">Contact Us</a></button>
        <?php
            session_start();
            echo "<h1><center>Welcome Page</center></h1>";
        
            echo "<div>Welcome ".$_SESSION['name']."</br>";
            echo "Your Email Id is ".$_SESSION['email']."</br>";
            echo "Gender: ".$_SESSION['gender']."</br>";
            echo "Your Mobile No. is ".$_SESSION['mobile']."</br></div>";
        ?>
    </body>
</html>