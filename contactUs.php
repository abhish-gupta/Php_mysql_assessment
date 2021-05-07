<?php 
    session_start();

    $name=$_SESSION['name'];
    $con=mysqli_connect('localhost','root');
        
    mysqli_select_db($con,'php_assignment');
  
    $priority = $title = $description ="";
    $priorityErr = $titleErr = $descriptionErr ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["priority"])) {
            $priorityErr = " Priority is required";
        } else {
            $priority = $_POST["priority"];
        }

        if (empty(trim($_POST["title"]))) {
            $titleErr = " Title is required";
        } else {
            $title = $_POST["title"];
        }
    
        if (empty(trim($_POST["description"]))) {
            $descriptionErr = "Description is required";
        } else {
            $description = $_POST["description"];
        }
    }
        $sql="select * from contact_us where title='$title' OR description='$description'";
        $result=mysqli_query($con,$sql);
        $num=mysqli_num_rows($result);
        if(!empty($priority) and !empty($title) and !empty($description)){
            if($num==0){
                $q = "insert into contact_us(title,priority,description,added_by) values ('$title','$priority','$description','$name')";
                mysqli_query($con,$q);
                echo "Data Submitted Successfully";
            }
            else{
                echo "Data already exists";
            }
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Contact Page</title>
        <link rel = "stylesheet" type="text/css" href="styles/contact.css">
        <style>
            .error{color: red;}
        </style>
    </head>
    <body>
      <div class="container">
         <h1>Contact Us Page</h1>
         <form name="ContactForm" method="POST">
            <div>
                <label for="priority">Priority:</label>
                <select name="priority" id="priority">
                    <option value="">Select</option>
                    <option <?php if (isset($priority) && $priority=="Low") echo "selected";?> value="Low">Low</option>
                    <option <?php if (isset($priority) && $priority=="Medium") echo "selected";?> value="Medium">Medium</option>
                    <option <?php if (isset($priority) && $priority=="High") echo "selected";?> value="High">High</option>
                </select>
                <span class="error">*<?php echo $priorityErr;?></span></br>
                <input type="text" value="<?php echo $title?>" name="title" placeholder="Title">
                <span class="error">*<?php echo $titleErr;?></span>
                <textarea type="text" name="description" placeholder="Decription"><?php echo $description?></textarea>
                <span class="error">*<?php echo $descriptionErr;?></span>
                <button type="submit" id="button">Submit</button>
            </div>
         </form>
      </div>
    </body>
</html>
