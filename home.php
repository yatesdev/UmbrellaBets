<?php 
    include_once "./php/db.php";
    // <!-- Jason Gentry
    // The homepage of the website that also displays a user's active bets and some of the various options of games to bet on. -->
    session_start();
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>

<html>
<head>
    <title>Umbrella Bets</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="./javascript/ajax.js"></script>
    <script>        
        $(document).ready(function(){
            HomeAjax();
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
            <div id="bets">
            </div>
            <div id="betlist">
            </div>
        </div>
</body>
<footer>
    <?php include "./php/footer.php";?>
</footer>
</html>