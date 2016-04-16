<?php
	include_once "./php/db.php";
	session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="./javascript/ajax.js"></script>
    <script>        
        $(document).ready(function(){
            UsermgmtAjax();
        })
    </script>
</head>

<body>
    <div class="header">
    	<?php include "./php/header.php";?>
    </div>
    <div class="wrapper">
        <div class="sidebar">
        </div>
        <div class="maincontent">
            <div id="userList"></div>
        </div>
</body>
<footer>
    <?php include "./php/footer.php";?>
</footer>
</html>
