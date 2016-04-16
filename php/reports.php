<?php
	include_once "db.php";
    require_once "JSON.php";
	session_start();

	function betsSidebar(){
        if($_SESSION['uid']==""){
            print('<p>Welcome Guest</p>
                   <p>You need to be logged in to see bets</p>');
        }
        else {
        	$timediffquery = 'TIMESTAMPDIFF(SECOND,NOW(),Games.time)';
            $query = 'SELECT Bets.betID as betID,Games.team1name,Games.team2name,Bets.amount,Bets.team,Bets.odds,Games.team1score,Games.team2score,'.$timediffquery.' FROM Bets
            INNER JOIN Games ON Bets.gameID = Games.gameID WHERE Games.status = "Active" AND Bets.userID = '.$_SESSION["uid"].' ORDER BY Bets.betID;';
            $result = mysql_query($query);
            $numrows = mysql_num_rows($result);
            print('<h3>'.$_SESSION["fname"].'\'s Bets</h3><hr width="90%"/>');
            print('<ul>');
            if($numrows == 0)
                print('You have no current bets.');
            else{
                for($rownum = 1; $rownum <= $numrows; $rownum++){
                    $row = mysql_fetch_array($result);
                    //Calculate time
                    $seconds = $row[$timediffquery];
                    $days    = floor($seconds / 86400);
					$hours   = floor(($seconds - ($days * 86400)) / 3600);
					$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
					$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
					$interval = $days.'D '.$hours.'H '.$minutes.'M Left';
                    print('<li>'.$row["team1name"]." ".$row['team1score']." -- ". $row["team2name"].' '.$row["team2score"].'<br/><small>
                        $'.$row["amount"].' on '.$row["team"].' at '.$row["odds"].':1 <br/>'.$interval.'</small></li>');
                }
            }
            print('</ul>');
        }
    }

    function homeBetList(){
        //Top 5 Most Popular Games (I.E Most bets on a game)
        $timediffquery = 'TIMESTAMPDIFF(SECOND,NOW(),Games.time)';
        $query = mysql_query('SELECT COUNT(Bets.betID) as numbets,Games.gameID as gameID,Games.team1name,Games.team2name,'.$timediffquery.',description FROM Bets 
            LEFT JOIN Games ON Bets.gameID = Games.gameID WHERE Games.status = "Active" GROUP BY Games.gameID ORDER BY numbets DESC LIMIT 5') or die(mysql_error());
        $numrows = mysql_num_rows($query);
        print('<table width="60%"><tr><td class="Header"><h2>Popular</h2></td></tr>');
        for($rownum = 1; $rownum <= $numrows;$rownum++){
            $row = mysql_fetch_array($query);
            //Calculate time
            $seconds = $row[$timediffquery];
            $days    = floor($seconds / 86400);
            $hours   = floor(($seconds - ($days * 86400)) / 3600);
            $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
            $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
            $interval = $days.'D '.$hours.'H '.$minutes.'M Left';
            if($_SESSION["uid"] == "")
	        	echo '<tr><td><b>'.$row["team1name"].' VS '. $row["team2name"].'</b> -- '.$interval."<br/><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["description"].'</small></td></tr>';
	        else
            	echo '<tr><td><a href="./bets.php?id='.$row["gameID"].'"><b>'.$row["team1name"].' VS '. $row["team2name"].'</b> -- '.$interval."<br/><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["description"].'</small></a></td></tr>';
        }
        print('</table>');

        //RECENT TOP 5
        $query = mysql_query('SELECT gameID,team1name,team2name,'.$timediffquery.',description FROM Games 
            WHERE status= "Active" AND time < ADDDATE(NOW(),INTERVAL 7 DAY) ORDER BY time LIMIT 5') or die(mysql_error());
        $numrows = mysql_num_rows($query);
        print('<table width="60%"><tr><td class="Header"><h2>This Week</h2></td></tr>');
        for($rownum = 1; $rownum <= $numrows;$rownum++){
            $row = mysql_fetch_array($query);
            //Calculate time
            $seconds = $row[$timediffquery];
            $days    = floor($seconds / 86400);
            $hours   = floor(($seconds - ($days * 86400)) / 3600);
            $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
            $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
            $interval = $days.'D '.$hours.'H '.$minutes.'M Left';
            if($_SESSION["uid"] == "")
            	echo '<tr><td><b>'.$row["team1name"].' VS '. $row["team2name"].'</b> -- '.$interval."<br/><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["description"].'</small></td></tr>';
            else
            	echo '<tr><td><a href="./bets.php?id='.$row["gameID"].'"><b>'.$row["team1name"].' VS '. $row["team2name"].'</b> -- '.$interval."<br/><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["description"].'</small></a></td></tr>';
        }
        print('</table>');
    }

    function fillGamesTable(){
        //Determine whether to show all or just specific category
        print('<table border="0" cellpadding="0" cellspacing="0" width="80%"><tr>');
        if($_POST['category'] == ""){
            $catresults = mysql_query('SELECT DISTINCT category FROM Games WHERE status = "Active" ORDER BY category');
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
                $gameresults = mysql_query("SELECT gameID,team1name,team2name FROM Games WHERE '$cat[category]' = category AND status = 'Active' ORDER BY team1name");
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
                    elseif($_SESSION["uid"] != ""){
                        print('<li><a style="display:block;" href="bets.php?id='.$game["gameID"].'">'.$game["team1name"].' vs. '.$game["team2name"].'</a></li>');
                    }
                    else{
                        print('<li><span style="display:block;line-height:30px;">'.$game["team1name"].' vs. '.$game["team2name"].'</span></li>');
                    }
                }
                print('</ul>
                    </td>
                    </tr>
                    </table>');
            }

            //Right Hand Column
            print('</td>
                <td valign="top" width="50%">');
            for($catnum = $numcatrows/2+$numcatrows%2; $catnum <$numcatrows;$catnum++){
                $cat = mysql_fetch_array($catresults);
                print('<table width=100% border="0"><tr><td class="CategoryHeader" id="'.$cat["category"].'"><h2>'.$cat["category"].'</h2></td></tr><tr>
                        <td><ul>');
                $gameresults = mysql_query("SELECT gameID,team1name,team2name FROM Games WHERE '$cat[category]' = category AND status = 'Active' ORDER BY team1name");
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
                    elseif($_SESSION["uid"] != ""){
                        print('<li><a style="display:block;" href="bets.php?id='.$game["gameID"].'">'.$game["team1name"].' vs. '.$game["team2name"].'</a></li>');
                    }
                    else{
                        print('<li><span style="display:block;line-height:30px;">'.$game["team1name"].' vs. '.$game["team2name"].'</span></li>');
                    }
                }
                print('</ul></td></tr></table>');
            }
        }
        else{ //Only display the selected column
            $catresults = mysql_query('SELECT DISTINCT category FROM Games WHERE status = "Active" AND category = "$_POST[category]" ORDER BY category');
            if(! $catresults){
                die('Invalid query: ' . mysql_error());
            }
            $numcatrows = mysql_num_rows($catresults);
            //Left Hand Column
            print('<td valign="top" width="50%">');
            for($catnum = 0; $catnum <=$numcatrows;$catnum++){
                $cat = mysql_fetch_array($catresults);
                print('
                    <table width=75% border="0">
                        <tr>
                        	<td class="CategoryHeader" id="'.$_POST["category"].'"><h2>'.$_POST["category"].'</h2></td> 
                        </tr>
                        <tr>
                        <td>
                        	<ul>');
                $gameresults = mysql_query("SELECT gameID,team1name,team2name FROM Games WHERE '$_POST[category]' = category AND status = 'Active' ORDER BY team1name");
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
                    elseif($_SESSION["uid"] != ""){
                        print('<li><a style="display:block;" href="bets.php?id='.$game["gameID"].'">'.$game["team1name"].' vs. '.$game["team2name"].'</a></li>');
                    }
                    else{
                        print('<li><span style="display:block; line-height:30px;>'.$game["team1name"].' vs. '.$game["team2name"].'</span></li>');
                    }
                }
                print('</ul>
                    </td>
                    </tr>
                    </table>');
            }
        }
        print('</tr></table>');
    }

    function fillBetTable(){
        $gameID = $_POST["id"];
        $gameInfo = mysql_query("SELECT * FROM Games WHERE gameID=$gameID");
        if (!$gameInfo) {
            die("Invalid query: ".mysql_error());
        }
        $gameArray = mysql_fetch_array($gameInfo);
        print('
        <form onsubmit="return checkBetAmount();" action="submit_bet.php">
        <input type="hidden" name="gameID" value="'.$gameID.'"/>
        <table border="2">
                <tr>
                    <th class = "bet_item" > Game ID </th>
                    <th class = "bet_item" > Teams </th>
                    <th class = "bet_item"> Odds </th>
                    <th class = "bet_item"> Game Time </th>
                </tr>
                <tr>
                    <td rowspan="2" class = "bet_item">'.$gameID.'</td>
                    <!-- Team 1 Name and odds -->
                    <td id="team1name" onmouseover="team1nameChange()" onmouseout="team1nameChangeBack();" class = "bet_item">'.$gameArray["team1name"].'</td>
                    <td class = "bet_item"> <label> <input type="radio" name="pointSpread" value="'.$gameArray["team1odds"].'" required>'.$gameArray["team1odds"].':1 </label> </td>
                    <td rowspan="2" class = "bet_item">'.date("D, d M Y g:i A", strtotime($gameArray["time"])).'</td>
                </tr>
                <tr>
                    <!-- Team 2 Name and odds -->
                    <td id="team2name" onmouseover="team2nameChange()" onmouseout="team2nameChangeBack()" class = "bet_item" >'.$gameArray["team2name"].'</td>
                    <td class = "bet_item"> <label> <input type="radio" name="pointSpread" value="'.$gameArray["team2odds"].'" required>'.$gameArray["team2odds"].':1 </label></td>
                </tr>
            </table>
            <p>
            Bet Amount: <span id="betAmountSpan"> <input type="number" min="1" name="betAmount" size="7" maxlength="7" value="10" id="betAmount"/> </span> <br /> <br />
            <input type="submit" value="Submit Bet" />
        </p>
        </form>');
    }
    function fillUserList(){
        $query = 'SELECT userID,firstname,lastname,username,isadmin FROM Users WHERE userID != 1';
        $results = mysql_query($query)or die(mysql_error());
        $rowcount = mysql_num_rows($results);
        print('<table width="60%"><tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th><th>Delete</th></tr>');
        for($rownum = 1; $rownum <= $rowcount; $rownum++){
            $row = mysql_fetch_array($results);
            if($row["isadmin"] == 1){
                print('<tr><td>'.$row["username"].'</td><td>'.$row["firstname"].'</td><td>'.$row["lastname"].
                '</td><td><input type="radio" name="'.$row["userID"].'" value="1" checked/>Admin<input type="radio" name="admin'.$row["userID"].'" value="0"/>Regular</td></tr>');
            }
            elseif($row["isadmin"] == 0){
                print('<tr><td>'.$row["username"].'</td><td>'.$row["firstname"].'</td><td>'.$row["lastname"].
                '</td><td><input type="radio" name="admin'.$row["userID"].'" value="1" />Admin<input type="radio" name="admin'.$row["userID"].'" value="0" checked/>Regular</td><td>
                <input type="button" name="delete'.$row["userID"].'" value="Delete"></td> </tr>');
            }
        }
        print('</table>');
    }

    function calculate(){
        $calcbets = '
            CREATE PROCEDURE Calculate_Bets()
                BEGIN
                DECLARE finished INT DEFAULT 0;
                DECLARE ubalance INT;
                DECLARE bet INT;
                DECLARE betteam VARCHAR(100);
                DECLARE betOdds INT;
                DECLARE betAmount INT;
                DECLARE uid INT;
                DECLARE gid INT;
                DECLARE t1n VARCHAR(100);
                DECLARE t2n VARCHAR(100);
                DECLARE t1s INT;
                DECLARE t2s INT;
                DECLARE c1 CURSOR FOR SELECT betID,Bets.gameID,Bets.userID,amount,odds,team FROM Bets,Games WHERE Bets.gameID = Games.gameID AND Games.status="Inactive" AND Games.isCalculated = 0;
                DECLARE c2 CURSOR FOR SELECT team1name,team2name,team1score,team2score FROM Games WHERE gameID = gid;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
                open c1;
                get_bets: LOOP
                    FETCH c1 INTO bet,gid,uid,betAmount,betOdds,betteam;
                    open c2;
                    FETCH c2 INTO t1n,t2n,t1s,t2s;
                    IF finished = 1 THEN
                        LEAVE get_bets;
                    END IF;
                    IF (t1s > t2s AND betteam = t1n) THEN
                        SELECT balance INTO ubalance FROM Users where userID = uid;
                        UPDATE Users SET balance = (ubalance +(betOdds*betAmount)) WHERE userID = uid;
                    END IF;
                    IF (t2s > t1s AND betteam = t2n) THEN
                        SELECT balance INTO ubalance FROM Users where userID = uid;
                        UPDATE Users SET balance = (ubalance +(betOdds*betAmount)) WHERE userID = uid; 
                    END IF;
                    IF(t1s = t2s) THEN
                        SELECT balance INTO ubalance FROM Users where userID = uid;
                        UPDATE Users SET balance = (ubalance + betAmount) WHERE userID = uid;
                    END IF;
                    UPDATE Games SET isCalculated = 1 WHERE gameID = gid;
                    CLOSE c2;
                    END LOOP;
                    CLOSE c1;                    
            END;';
        $updategames = '
            CREATE PROCEDURE Update_Games()
                BEGIN
                DECLARE finished INT DEFAULT 0;
                DECLARE val INT DEFAULT 0;
                DECLARE val2 INT DEFAULT 0;
                DECLARE c1 CURSOR FOR SELECT gameID FROM Games WHERE status = "Active" AND time < SYSDATE();
                DECLARE c2 CURSOR FOR SELECT gameID FROM Games WHERE status = "Inactive" AND time > SYSDATE();
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished=1;
                    open c1;
                    open c2;
                    get_rows: LOOP
                        FETCH c1 INTO val;
                        IF finished = 1 THEN
                            LEAVE get_rows;
                        END IF;
                        UPDATE Games SET status="Inactive" WHERE gameID = val;
                    END LOOP;
                    SET finished = 0;
                    get_rows2: LOOP
                        FETCH c2 INTO val2;
                        IF finished = 1 THEN
                            LEAVE get_rows2;
                        END IF;
                        UPDATE Games SET status="Active" WHERE gameID = val2;
                    END LOOP;
                    CLOSE c1;
                    CLOSE c2;
                END;';
        $result = mysql_query('DROP PROCEDURE IF EXISTS Update_Games;')or die(mysql_error());
        $result = mysql_query('DROP PROCEDURE IF EXISTS Calculate_Bets;')or die(mysql_error());
        $result = mysql_query($updategames)or die(mysql_error());
        $result = mysql_query($calcbets)or die(mysql_error());
        $result = mysql_query('CALL Update_Games();') or die(mysql_error());
        $result = mysql_query('CALL Calculate_Bets();')or die(mysql_error());
        //Update session variable to reflect balance changes
        if($_SESSION["uid"] != ""){
            $result = mysql_query('SELECT balance FROM Users WHERE userID = '.$_SESSION["uid"].';')or die(mysql_error());
            $balance = mysql_fetch_array($result);
        	$winamount = $balance["balance"] - $_SESSION["balance"];
            $_SESSION["balance"] = $balance["balance"];
            echo json_encode(array('balance' => $_SESSION["balance"] , 'winnings' => $winamount));
        }
    }

    //Determines which method to run.
    if(isset($_POST['request']) && !empty($_POST['request'])) {
	    $request = $_POST['request'];
	    switch($request) {
	        case 'betsSidebar' : betsSidebar();break;
	        case 'homeBetList' : homeBetList();break;
	        case 'fillGamesTable' : fillGamesTable();break;
            case 'fillBetTable' : fillBetTable();break;
            case 'fillUserList' : fillUserList();break;
	        case 'update' : calculate();break;
	    }
	}
?>