<?php 
    include_once "./php/db.php";

    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    function fillGamesList(){
        $gamequery = "SELECT * FROM Games ORDER BY category,team1name";
        $result = mysql_query($gamequery);
        $numrows = mysql_num_rows($result);
        print('<table class="DeleteGame"><tr><td class="CategoryHeader" colspan="5"><h2>Delete Game</h2</td></tr>
        ');
        for($rownum = 1; $rownum <= $numrows;$rownum++){
            $row = mysql_fetch_array($result);
            print('<tr><td><input type="checkbox" name="gameID[]" value="'.$row["gameID"].'" /></td><td class="line_item">'.$row["team1name"].' vs. '.$row["team2name"].'</td><td class="line_item">'.$row["time"].'</td><td class="line_item">'.$row["category"].'</td><td class="line_item">'.$row["status"].'</td></tr>');
        }
        print('</table>');
    }
?>

<html>

<head>
    <title>Delete Game</title>
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
        <form id="del_game_form" action="submit_game.php" method="get">
            <input type="hidden" name="submitType" value="delete"/>
            <?php fillGamesList(); ?>
            <input type="submit" value="Delete" />
        </form>
    </div>
</body>
<footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.html">Games</a>
    </nav>
</footer>

</html>
<!--Mike Yates
    This page allows the deletion of games, which are then deleted via the submit_game page. -->