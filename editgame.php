<!--Mike Yates
    This page allows the editing of game fields, which are then submitted via the submit_game page. -->
<?php 
    include_once "./php/db.php";

    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    function fillForm(){
        $query = "SELECT gameID,team1name,team2name,time,description,category,team1odds,team2odds,team1score,team2score,status FROM Games WHERE gameID=".$_GET['id'];
        $result = mysql_query("SELECT * FROM Games WHERE gameID=".$_GET['id']);
        global $row;
        $row = mysql_fetch_array($result);
    }
    function fillCategoryOptionList(){
        $categories = mysql_query("SELECT DISTINCT category FROM Games ORDER BY category");
        $gameMatchQuery = mysql_query("SELECT gameID,category FROM Games WHERE gameID= ".$_GET['id']);
        $gameMatch = mysql_fetch_array($gameMatchQuery);
        $numrows1 = mysql_num_rows($categories);
        print('<select id="selectcat" onchange="showNewCategory();" name="GameCategory" required="true">
        		<option disabled value=""> -- select an option -- </option>
        		<option value="--New--"> -- New -- </option>');
        for($rownum =1;$rownum <= $numrows1;$rownum++){
                $cat = mysql_fetch_array($categories);
                if($cat['category'] == $gameMatch['category'])
                    print('<option selected value="'.$cat["category"].'">'.$cat["category"].'</option>');
                else
                    print('<option value="'.$cat["category"].'">'.$cat["category"].'</option>');
        }
        print('</select>');
    }
?>
<html>

<head>
    <title>Edit Game</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    <script type="text/javascript">
        function showNewCategory(){
            var selectcat = document.getElementById('selectcat');
            var newCategory = document.getElementById('newCategory');   
            var newCategoryInput = document.getElementById('newCategoryInput');  
            var val = selectcat.value;
            if(val == "--New--"){
                newCategory.style.display = '';
                newCategoryInput.value = '';
                newCategoryInput.required = true;
            }
            else{
                newCategory.style.display = 'none';
                newCategoryInput.value = 'NADA';
                newCategoryInput.required = false;
            }
        }
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
        <!--Main page content which will load based upon the categories found in the database -->
        <div class="maincontent">
        <form id="new_game_form" action="submit_game.php" onsubmit="return validateForm()" method="get">
            <input type="hidden" name="submitType" value="edit"/>
            <input type="hidden" name="gameID" value="<?php echo $_GET["id"];?>"/>
            <table class="EditGame">
                <tr>
                    <td class="Header" colspan="3"><h2>Edit game</h2></td>
                </tr>
                <tr>
                <td><?php fillForm();?></td>
                </tr>
                <tr>
                    <td>Side 1 Name:</td>
                    <td><input type="text" name="side1Name" value="<?php echo $row['team1name'];?>" placeholder="Team1" required="true"/></td>
                </tr>
                <tr>
                    <td>Side 2 Name:</td>
                    <td><input type="text" name="side2Name" value="<?php echo $row['team2name'];?>" placeholder="Team2" required="true"/></td>
                </tr>
                <tr>
                    <td valign="top">Description:</td>
                    <td><textarea rows="5" cols="50" name="GameDescription" placeholder="Description"><?php echo $row['description'];?></textarea></td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td><input type="datetime-local" name="GameTime" value="<?php echo date("Y-m-d\TH:i:s",strtotime($row['time']));?>" required="true"/></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td><?php fillCategoryOptionList(); ?></td>
                </tr>
                <tr id="newCategory" style="display:none;">
                	<td width="21px">New Category:</td>
                	<td><input id="newCategoryInput" type="text" name="newCategory" value=""/></td>
                </tr>
                <tr>
                    <td>Odds Side 1:</td>
                    <td><input type="number" name="OddsTeam1" value="<?php echo $row['team1odds'];?>" size="4" required="true" min="1"/>:1</td>
                </tr>
                <tr>
                    <td>Odds Side 2:</td>
                    <td><input type="number" name="OddsTeam2" value="<?php echo $row['team2odds'];?>" size="4" required="true" min="1"/>:1</td>
                </tr>
                <tr>
                    <td>Score Side 1:</td>
                    <td><input type="number" name="ScoreTeam1" value="<?php echo $row['team1score'];?>" size="4" required="true" min="0"/></td>
                </tr>
                <tr>
                    <td>Score Side 2:</td>
                    <td><input type="number" name="ScoreTeam2" value="<?php echo $row['team2score'];?>" size="4" required="true" min="0"/></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="GameSubmit" /></td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</body>
<footer>
    <nav class="fnavbar">
        <a href="home.html">Home</a>
        <a href="games.html">Games</a>
    </nav>
</footer>

</html>
