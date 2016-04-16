<?php 
    include_once "./php/db.php";
    
    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    
    function fillCategoryOptionList(){
    	$getcategories = "SELECT DISTINCT category FROM Games ORDER BY category";
        $categories = mysql_query($getcategories);
        if(! $categories){
            die('Invalid query: ' . mysql_error());
            exit;
        }
        $numrows = mysql_num_rows($categories);
        print('<select id="selectcat" onchange="showNewCategory();" name="GameCategory" required="true">
        		<option disabled selected value=""> -- select an option -- </option>
        		<option value="--New--"> -- New -- </option>');
        for($rownum =1;$rownum <= $numrows;$rownum++){
                $row = mysql_fetch_array($categories);
                print('<option value="'.$row["category"].'">'.$row["category"].'</option>');
        }
        print('</select>');

    }
?>
<html>
<head>
    <title>Add Game</title>
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
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="./javascript/ajax.js"></script>
    <script>        
        $(document).ready(function(){
            CommonAjax();
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
        <!--Main page content which will load based upon the categories found in the database -->
        <form id="new_game_form" action="submit_game.php" onsubmit="return validateForm()" method="get">
            <input type="hidden" name="submitType" value="add"/>
            <table class="AddGame">
                <tr>
                    <td class="Header" colspan="3"><h2>Add a game</h2></td>
                </tr>
                <tr>
                    <td>Side 1 Name:</td>
                    <td><input type="text" name="side1Name" value="" placeholder="Team1" required="true"/></td>
                </tr>
                <tr>
                    <td>Side 2 Name:</td>
                    <td><input type="text" name="side2Name" value="" placeholder="Team2" required="true"/></td>
                </tr>
                <tr>
                    <td valign="top">Description:</td>
                    <td><textarea rows="5" cols="50" name="GameDescription" placeholder="Description"></textarea></td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td><input type="datetime-local" name="GameTime" value="" required="true"/></td>
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
                    <td><input type="number" name="OddsTeam1" value="" size="4" required="true"/>:1</td>
                </tr>
                <tr>
                    <td>Odds Side 2:</td>
                    <td><input type="number" name="OddsTeam2" value="" size="4" required="true"/>:1</td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="GameSubmit" /></td>
                </tr>
            </table>
        </form>
    </div>
</body>
<footer>
    <?php include "./php/footer.php";?>
</footer>

</html>
<!--Mike Yates
    This page adds a game to the database.
-->