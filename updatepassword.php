<?php include_once "./php/db.php";
            session_start();
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="home.css">
        <title>
            Update Password
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
            /* $numrows = mysql_num_rows($result);
            for($rownum =1;$rownum <= $numrows;$rownum++){
                    
            } */
            $row = mysql_fetch_array($result);
            if($_POST['currpw']==$row['password'] && $_POST['pw'] == $_POST['cpw']){
                $new=$_POST['pw'];
                $update="UPDATE Users SET password = '$new' WHERE Users.userID = '$usrID'";
                $result = mysql_query($update);
                if(!$result)
                    echo mysql_error();
                else
                    echo "Password successfully updated.";
            }
            else if ($_POST['currpw']!=$row['password']){
                
                echo "Your current password was incorrect. User was not updated.";
            }
            else{
                echo "User was not updated.";
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
Description: Response to accountpref.php. Contains sql code to update the current user's password. Displays a message if successful. This assumes all javascript verificiations in accountpref.php are passed.
-->