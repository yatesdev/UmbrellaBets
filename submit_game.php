<!--Mike Yates
    This page is the all inclusive submission landing page for adding, editing and deleting games.-->
<?php 
    include_once "./php/db.php";

    session_start();
    //print_r($_SESSION);
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    function editGame(){
        $currentTime = date("Y-m-d H-i-s");
        $gameTime = $_GET["GameTime"];
        $gameTime = str_replace("T", " ", $gameTime);
        $gameTime = str_replace(":", "-", $gameTime).'-00';
        $status = "";
        if($currentTime < $gameTime){
            $status = "Active";
        }
        else{
            $status = "Inactive";
        }
        $catValue = $_GET["GameCategory"];
        $altCatValue = $_GET["newCategory"];
        if($catValue == "--New--"){
            $catValue = $altCatValue;
        }
        $submitquery = 'UPDATE Games SET team1name = "'.$_GET["side1Name"].'", team2name = "'.$_GET["side2Name"].'",time = "'.$gameTime.'",description = "'.$_GET["GameDescription"].'",category = "'.$catValue.'",team1odds = '.$_GET["OddsTeam1"].',team2odds = '.$_GET["OddsTeam2"].',team1score = '.$_GET["ScoreTeam1"].',team2score = '.$_GET["ScoreTeam2"].',status ="'.$status.'" 
        WHERE gameID = '.$_GET["gameID"].';';
        $result = mysql_query($submitquery);
        
        if($result == 1){
            echo 'Game between '.$_GET["side1Name"].' and '.$_GET["side2Name"].'<br/>has been successfully edited.';
            echo '<script type="text/javascript">window.document.title = "Success";</script>';
        }
        else {
            echo 'Game creation was unsuccessful.';
            echo mysql_error();
            echo '<script type="text/javascript">window.document.title = "Failed";</script>';
        }
    }

    function deleteGame(){
        $gamesToDelete = $_GET['gameID'];
        foreach ($gamesToDelete as $game) {
            $names = mysql_query('SELECT side1Name,side2name FROM Games WHERE gameID= '."$game");
            $result = mysql_query('DELETE FROM Games WHERE gameID = '."$game");
            if($result == 1){
                echo 'Game between '.$names["side1Name"].' and '.$names["side2name"].'<br/>has been successfully deleted from the database.';
                echo '<script type="text/javascript">window.document.title = "Success";</script>';
            }
            else {
                echo 'Game deletion was unsuccessful.';
                echo mysql_error();
                echo '<script type="text/javascript">window.document.title = "Failed";</script>';
            }
        }
    }
    function addGame(){
        $currentTime = date("Y-m-d H-i-s");
        $gameTime = $_GET["GameTime"];
        $gameTime = str_replace("T", " ", $gameTime);
        $gameTime = str_replace(":", "-", $gameTime).'-00';
        $status = "";
        if($currentTime < $gameTime){
            $status = "Active";
        }
        else{
            $status = "Inactive";
        }
        $catValue = $_GET["GameCategory"];
        $altCatValue = $_GET["newCategory"];
        if($catValue == "--New--"){
            $catValue = $altCatValue;
        }
        $submitquery = 'INSERT INTO Games (team1name,team2name,time,description,category,team1odds,team2odds,status)
                        VALUES ("'.$_GET["side1Name"].'","'.$_GET["side2Name"].'","'.$gameTime.'","'.$_GET["GameDescription"].'","'.$catValue.'",'.$_GET["OddsTeam1"].','.$_GET["OddsTeam2"].',"'.$status.'");';
        $result = mysql_query($submitquery);
        
        if($result == 1){
            echo 'Game between '.$_GET["side1Name"].' and '.$_GET["side2Name"].'<br/>has been successfully added to the database.';
        	echo '<script type="text/javascript">window.document.title = "Success";</script>';
        }
        else {
            echo 'Game creation was unsuccessful.<br/>';
            echo mysql_error();
        	echo '<script type="text/javascript">window.document.title = "Failed";</script>';
        }
    }
?>
<html>
<head>
    <title>Submit Game</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    
</head>

<body>
    <div class="header">
        <?php include "./php/header.php";?>
    </div>
    <div class="wrapper">
        <div class="sidebar">
            <?php include "./php/sidebar.php";?>
        </div>
        <!--Main page content which will load based upon the categories found in the database -->
        <div class="maincontent">
            <?php 
                if($_GET["submitType"] == "add"){
                    addGame();
                }
                elseif ($_GET["submitType"] == "edit") {
                    editGame();
                }
                elseif ($_GET["submitType"] == "delete"){
                    deleteGame();
                }
                else{
                    echo "No valid submitType.";
                }
            ?>
            <form action="games.php" method="link">
                <input type="submit" value="OK"/>
            </form>
        </div>

    </div>
</body>
<footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.html">Games</a>
        <a href="bets.html">Bets</a>
        <a href="newaccount.html">Create Account</a>
        <a href="coming soon.html">Coming Soon</a>
        <a href="stuff.html">Stuff</a>
    </nav>
</footer>
</html>