<?php include_once "./php/db.php";
            session_start();
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="home.css">
        <title>
            Change Email
        </title>
        
    </head>
    <body>
        <div class="header">
    	<?php include "./php/header.php";?>
        </div>
        <div class="wrapper">
            <div class="sidebar">
                <?php include "./php/sidebar.php";?>
            </div>
        <?php 
            $usrID=$_SESSION['uid'];
            $query="SELECT* from Users where userID = '$usrID'"; 
            $result=mysql_query($query);
            $numrows = mysql_num_rows($result);
           //$numrows = mysql_num_rows($result);
            $row = mysql_fetch_array($result);
               
           if($_POST['pw']==$row['password'] && $_POST['usrname']==$row['username']){
                   $new=$_POST['email'];
                   $query2="SELECT* from Users where email='$new'";
                   $result2=mysql_query($query2);
                   $numrows=mysql_num_rows($result2);
                   
                   if($numrows>0){
                       echo "There is already an existing account with that email";
                   }
                   else{
                       $update="UPDATE Users SET email = '$new' WHERE Users.userID = '$usrID'";
                       mysql_query($update);
                   }
                   
                   if(!$result)
                       echo mysql_error();
                   else
                       echo "Email successfully updated";
               }
            else if($_POST['pw']!=$row['password']){
                echo "Incorrect password. User's email was not updated";
            }
           else{
               echo "Incorrect username. User's email was not updated";
           }
		  ?>
            <form action="./home.php" method="link">
                <input type="submit" value="OK"/>
            </form>
		    
         </div>
    </body>
    <footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.php">Games</a>
    </nav>
</footer>
</html>
<!--
Author: Kimberly Lanman
Description: Response to accountpref.php. Contains sql code to update the change the user's email. Displays a message if successful. This assumes all javascript verificiations in accountpref.php are passed.
-->