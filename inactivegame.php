<?php 
    include_once "./php/db.php";
    
    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    function fillGamesTable(){
    //Only display the selected column
        $catresults = mysql_query('SELECT DISTINCT category FROM Games WHERE status = "Inactive" ORDER BY category');
        if(! $catresults){
            die('Invalid query: ' . mysql_error());
        }
        $numcatrows = mysql_num_rows($catresults);
        //Left Hand Column
        print('<td valign="top" width="50%">');
        for($catnum = 1; $catnum <=$numcatrows;$catnum++){
            $cat = mysql_fetch_array($catresults);
            print('
                <table width=75% border="0">
                    <tr>
                    	<td class="CategoryHeader" id="'.$cat["category"].'"><h2>'.$cat["category"].'</h2></td> 
                    </tr>
                    <tr>
                    <td>
                    	<ul>');
            $gameresults = mysql_query("SELECT gameID,team1name,team2name FROM Games WHERE category = '".$cat['category']."' AND status = 'Inactive' ORDER BY team1name");
            if(! $gameresults){
                die('Invalid query: ' . mysql_error());
            }
            $numgamerows = mysql_num_rows($gameresults);
            for($gamenum = 1; $gamenum <= $numgamerows; $gamenum++){
                $game = mysql_fetch_array($gameresults);
                if($_SESSION["isadmin"]){
                print('<li><a href="bets.php?id='.$game["gameID"].'">'.$game["team1name"].' vs. '.$game["team2name"].'</a>');
                print('<form method="post" style="display:inline;" action="editgame.php?id='.$game["gameID"].'"><input type="submit" value="Edit"/></form></li>
                    ');
                }
                else{
                    print('<li><a style="display:block;" href="bets.php?id='.$game["gameID"].'">'.$game["team1name"].' vs. '.$game["team2name"].'</a>');
                }
            }
            print('</ul>
                </td>
                </tr>
                </table>');
        }
    }
?>
<html>
<head>
    <title>Games</title>
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
        <div class="maincontent">
        <!--Main page content which will load based upon the categories found in the database -->
        <table border="0" cellpadding="0" cellspacing="0" width="80%">
            <tr>
            <?php fillGamesTable();?>
            </tr>
        </table>
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
<!-- Mike Yates
    This page shows all of the inactive games in the database. -->