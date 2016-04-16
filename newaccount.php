<?php include_once "./php/db.php";
		session_start();
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>
<html>
<head>
	<title>New Account</title>
	<script type="text/javascript" src=" http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js "></script>
	<script type = "text/javascript" src="./javascript/verifyForm.js"></script>
	<link rel="stylesheet" type="text/css" href="home.css" />
	<link rel="shortcut icon" href="./img/favicon.png">
</head>
<body>
<div class="header">
       <?php include "./php/header.php"; ?>
    </div>
    <div class="wrapper">
        <div class="sidebar">
            <?php include "./php/sidebar.php";?>
        </div>
		<div class = "newForm">
			<h4> Create a new account</h4>
				<form name = "create_account" id="create_account" action = "submit_newaccount.php" method = "post">
				<fieldset class = "personaldata">
					<legend> Personal Information </legend>
					<table>
						<tr>
							<td class = "label"> <label>First Name </label></td>
							<td class = "field"><input type="text" id="fname" name="fname" required pattern="^[a-zA-Z]+$" placeholder="must not contain digits"/></td>
						</tr>
						<tr>
							<td class = "label"><label>Last Name</label></td>
							<td class="field"><input type="text" id="lname" name="lname" required pattern= "^[a-zA-Z]+$" placeholder="must not contain digits"/></td>
						</tr>
						<tr>
							<td class="label"><label>Email</label></td>
							<td class="field"><input type="text" id="email" name= "email" required pattern="([\w\-]+\@[\w\-]+\.[\w\-]+)" placeholder="jdoe@domain.example" /></td>
						</tr>
					</table>
				</fieldset>
				<fieldset class="logindata">
					<legend> Login Fields </legend>
					<table>
						<tr>
							<td class="label"><label>Username</label></td>
							<td class="field"><input type = "text" id="username" name="username"  value="" onchange="checkAvail(this.value)" required placeholder="examples: jdoe, jdoe45, JdoE"/><span id="msgbox"></span></td>
						</tr>
						<tr>
							<td class="label"><label>Password</label></td>
							<td class="field"><input type="password" id="pw" name = "pw" required pattern = "(?=.*\d)(?=.*[A-z]).{8,}" placeholder="8+ characters, at least one number"/></td>
						</tr>
						<tr>
							<td class="label"><label>Confirm Password</label></td>
							<td class="field"><input type="password" id="cpw" name= "cpw" required placeholder="confirm password" pattern="(?=.*\d)(?=.*[A-z]).{8,}" onkeyup = "checkPW(this.value)"/><span id="confirmpw"></span></td>
						</tr>
					</table>
				</fieldset>
				<fieldset class="amount">
					<legend>Betting</legend>
					<table>
					<tr>
						<td class="label"><label>Starting amount</label></td>
						<td class="field"><input type="text"id="amount" name = "amount" required pattern="^\d{1,10}(\.\d{0,2})?$" placeholder="examples: 2567.65, 35, 0" /></td>
					</tr>
					</table>
				</fieldset>
				<fieldset class="buttons">
					<input type="submit" id="signup" name="signup" value="Sign Up!" onclick="return checkAll();" />
					<input type ="reset" value ="Reset"/>
				</fieldset>
			</form> 
	</div>
</div>
<footer>
  <?php include "./php/footer.php";?>
</footer>
</body>
<!--
Author: Kimberly Lanman
Description: This is the php page that contains the form for creating a new account.
-->
