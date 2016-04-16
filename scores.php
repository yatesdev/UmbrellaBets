<?php 
    include_once "./php/db.php";
    session_start();
    //<!--Mike Yates
    //This pages shows all of the active games if no category is selected. If a category is selected from the sidebar, then the list of games is filtered. -->
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    function fillGamesTable(){
        //Determine whether to show all or just specific category
        $catresults = mysql_query('SELECT DISTINCT category FROM Games ORDER BY category');
        if(! $catresults){
            die('Invalid query: ' . mysql_error());
        }
        $numcatrows = mysql_num_rows($catresults);

        //Left Hand Column
        print('<td valign="top" width="50%">');
        for($catnum = 1; $catnum <=$numcatrows/2+$numcatrows%2;$catnum++){
            $cat = mysql_fetch_array($catresults);
            print('
                <table width=100% border="0" frame="rhs">
                    <tr>
                    <td class="CategoryHeader" id="'.$cat["category"].'"><h2>'.$cat["category"].'</h2></td> 
                    </tr>
                    <tr>
                    <td>
                    <ul>');
            $gameresults = mysql_query("SELECT gameID,team1name,team2name,team1score,team2score FROM Games WHERE '$cat[category]' = category ORDER BY team1name");
            if(! $gameresults){
                die('Invalid query: ' . mysql_error());
            }
            $numgamerows = mysql_num_rows($gameresults);
            for($gamenum = 1; $gamenum <= $numgamerows; $gamenum++){
                $game = mysql_fetch_array($gameresults);
                print('<li><span style="display:block;line-height:30px;">'.$game["team1name"].' vs. '.$game["team2name"].
                	'<span style="float:right;padding-right:20px;">'.$game["team1score"].' -- '.$game["team2score"].'</span></li>');
            }
            print('</ul></td></tr></table>');
        }

        //Right Hand Column
        print('</td>
            <td valign="top" width="50%">');
        for($catnum = $numcatrows/2+$numcatrows%2; $catnum <$numcatrows;$catnum++){
            $cat = mysql_fetch_array($catresults);
            print('<table width=100% border="0"><tr><td class="CategoryHeader" id="'.$cat["category"].'"><h2>'.$cat["category"].'</h2></td></tr><tr>
                    <td><ul>');
            $gameresults = mysql_query("SELECT gameID,team1name,team2name,team1score,team2score FROM Games WHERE '$cat[category]' = category ORDER BY team1name");
            if(! $gameresults){
                die('Invalid query: ' . mysql_error());
            }
            $numgamerows = mysql_num_rows($gameresults);
            for($gamenum = 1; $gamenum <= $numgamerows; $gamenum++){
                $game = mysql_fetch_array($gameresults);
                print('<li><span style="display:block;line-height:30px;">'.$game["team1name"].' vs. '.$game["team2name"].
                	'<span style="float:right;padding-right:20px;">'.$game["team1score"].' -- '.$game["team2score"].'</span></li>');
            }
            print('</ul></td></tr></table>');
        }
    }
?>
<html>
<head>
    <title>Scores</title>
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
    <?php include "./php/footer.php";?>
</footer>

</html>
