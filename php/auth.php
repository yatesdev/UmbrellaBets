<?php
	session_start();
	include_once "./db.php";
	
	// Mike Yates
	// This page maintains the session variables for logging in and logging out
	function login($uname,$pass){
		$query = "SELECT userID,firstname,lastname,username,password,isadmin,balance FROM Users WHERE username = "."'$uname'"." AND password = "."'$pass'";
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		for($rownum =1;$rownum <= $numrows;$rownum++){
                $row = mysql_fetch_array($result);
        }
		if($result){
			$_SESSION['uid'] = $row['userID'];
			$_SESSION['fname'] = $row['firstname'];
			$_SESSION['isadmin'] = $row['isadmin'];
			$_SESSION['balance'] = $row['balance'];		
		}
		else{
			$_SESSION['uid'] = "";
			$_SESSION['fname'] = "";
			$_SESSION['isadmin'] = "0";
			$_SESSION['balance'] = "0";
		}
		if(isset($_SESSION['url']) )//AND !strpos($_SESSION['url'],'newaccount')) 
   			$url = $_SESSION['url']; // holds url for last page visited.
		else 
   			$url = "../home.php";
		header("Location:".$url);		
	}

	function logout(){
		$_SESSION['uid'] = "";
		$_SESSION['fname'] = "";
		$_SESSION['isadmin'] = "";
		$_SESSION['balance'] = "0";

   		$url = "../home.php";
		header("Location:".$url);
	}

	$uname = $_POST["username"];
	$pass = $_POST["password"];
	if($_SESSION["uid"] != ""){
		logout();
	}
	else{
		login($uname,$pass);
	}
	session_write_close();
?>