<?php
	session_start();
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	include_once "./php/db.php" 
?>;
<html>
<head>
	<title>New Account</title>
	<link rel="stylesheet" type="text/css" href="home.css" />  
</head>
<body>
   
<div class="header">
        <?php include "./php/header.php";?>
</div>
    
       
    <div class="wrapper">
        <div class="sidebar">
            <?php include "./php/sidebar.php";?>
        </div>

	<p>
        <?php
            
	    
	    
	    /*Username availability will be checked while typing using ajax. Password matching confirm password will use javascript*/ 
		$fnm= $_POST['fname'];
		$lnm=$_POST['lname'];
		$usrnm=$_POST['username'];
		$eml=$_POST['email'];
		$psw=$_POST['pw'];
		$amt=$_POST['amount'];
		$query="SELECT* FROM Users WHERE email = '$eml'"; /* OR username = '$usrnm'"); */
		$select= mysql_query($query); 
		$numrows = mysql_num_rows($select);
		if($numrows>0):?>
		    
		    <p> You already have an existing account with us. <br /> Please go <a href="newaccount.php">back</a> and try again </p>
		    
		
		<?php else:
		   $toInsert=("INSERT INTO Users(email,firstname,lastname,username,isadmin,password,balance) VALUES ('$eml', '$fnm', '$lnm', '$usrnm', 0, '$psw', '$amt')");
			$insert= mysql_query($toInsert);
		   
		    if($insert):?>
				
				 
			<p> Welcome to Umbrella Bets. <br />Login with your new username and password below to get started<br /></p>
			<form method="post" action="./php/auth.php" style="display:inline;">
			<p>
           	<input type="text" name="username" value="" placeholder="Username or Email">
           	</p>
           	<p>
           	<input type="password" name="password" value="" placeholder="Password">
           	</p>
           	<input type="submit" name="commit" value="Login">
			</form>
		   <?php else:?>
		       <!--Will be checked while typing but for now it is checked after submitting and while inserting since username is a unique index in the users table-->
		        Username: <?php echo(" $usrnm") ?>  is already taken <br />
				Go <a href="newaccount.php">back</a> and try again
		   <?php endif;?>
		 <?php endif;?>
    </p>
    </div>
</div>
<footer>
<?php include "./php/footer.php";?>
</footer>
</body>
</html>
<!--
Author: Kimberly Lanman
Description: This is the php file for creating a new account. After the a potential new user  fills out and submits the new account form in newaccount.html, this page will be displayed. Right now, it is assumed that the form input that will be verified using javascript is already valid. But that will be changed later since javascript and ajax will be used for verifying most of the input fields on submit. The only fields checked after submit in this file are the email (if it already exists) and user name (if already exists). If those two checks are passed, then the user's information from the form is stored in the users database and the user is asked to login using their new username and their password.
-->