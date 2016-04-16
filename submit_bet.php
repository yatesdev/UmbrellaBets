<?php
        include_once "./php/db.php";

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];?>
<html>
<head>
    <title>Games</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
        
    
        <?php
        #get the game ID
        $gameID = $_GET["gameID"];
        $pointSpread = $_GET["pointSpread"];
        $betAmount = $_GET["betAmount"];
        #GET THIS FROM SESSION INFO
        $userID = $_SESSION["uid"];
        
        $gameInfo = mysql_query("SELECT * FROM Games WHERE gameID=$gameID");
        if (!$gameInfo) {
            die("Invalid query: ".mysql_error());
        }
        $gameArray = mysql_fetch_array($gameInfo);
        
        if ($pointSpread == $gameArray[team1odds]) {
            $team = $gameArray[team1name];
        } else {
            $team = $gameArray[team2name];
        }
        
        #Add the bets to the database
        $addBet = mysql_query("INSERT INTO Bets(gameID, userID, amount, odds, team) VALUES($gameID, $userID, $betAmount, $pointSpread, '$team')");
        if (!$addBet) {
            die ("Invalid query: ".mysql_error());
        }
        else{
            $query = mysql_query("SELECT balance FROM Users where userID = ".$_SESSION['uid']);
            $currbalance = mysql_fetch_array($query);
            $newbalance= $currbalance["balance"] - $betAmount;
            $_SESSION["balance"] = $newbalance;
            $result = mysql_query("UPDATE Users SET balance = ".$_SESSION["balance"]." WHERE Users.userID = '$userID'");
            if(!$result)
                die(mysql_error());
        }
    ?>
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
            <h2> Thank you for your submission! </h2> <br />
            <h3> You have bet $<?php echo $betAmount; ?> on (the) <?php echo $team; ?> </h3>
            <form action="./home.php" method="link">
                <input type="submit" value="OK"/>
            </form>
        
        </div>
    </div>
</body>
<footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.php">Games</a>
    </nav>
</footer>

</html>
<!-- John Malloy
    This page is the landing page when a user creates a bet
    -->