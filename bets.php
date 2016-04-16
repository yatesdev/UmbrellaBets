<?php
    include_once "./php/db.php";
    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>
<html>
<head>
    <title>Bet</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="./javascript/ajax.js"></script>
    <script src="./javascript/changeCss.js"></script>
    <script>        
        $(document).ready(function(){
            ajaxBetTable(<?php echo $_GET["id"]?>);
        })
    </script>       
</head>
<body>
    <div class="header">
        <?php include "./php/header.php";?>
    </div>
    <div class="wrapper">
        <div class="sidebar">
            <?php include "./php/sidebar.php";?>
        </div>
        <div class="maincontent">
        <!--Main page content which will load based upon the categories found in the database -->
        <div id="bets_table"></div>
    </div>
</body>
<footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.php">Games</a>
    </nav>
</footer>
</html>
<!--John Malloy
    This page allows the creation of a bet on a game. -->