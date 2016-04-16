<?php session_start();?>
<!--Mike Yates  This page is the template for the header, which is called on all pages-->
<img class="logo" src="./img/logosmall.png" />
<div class="login">
   	<?php if($_SESSION["uid"]):?>
       	<p>Welcome, <?php echo $_SESSION["fname"]?></p>
        <p id="balance">Balance: <?php echo $_SESSION["balance"]?></p>
       	<form method="post" action="./php/auth.php" style="display:inline;">
       		<input type="submit" name="commit" value="Logout"/>
       	</form>
        <form method="post" action="./accountprefs.php" style="display:inline;">
          <input type="submit" name="commit2" value="Account Prefs."/>
        </form>
   	<?php else: ?>
   		<form method="post" action="./php/auth.php" style="display:inline;">
           	<p>
           	<input type="text" name="username" value="" placeholder="Username">
           	</p>
           	<p>
           	<input type="password" name="password" value="" placeholder="Password">
           	</p>
           	<input type="submit" name="commit" value="Login">
       	</form>
       	<button onclick="location.href='newaccount.php'">Create Account</button>
   	<?php endif; ?>
</div>
<h1><br/><br/>Umbrella Bets<br/><h3>The Totally Not Illegal Sports Betting Website</h3></h1>
<nav>
    <ul class="navbar">
        <li><a href="home.php">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="scores.php">Scores</a></li>
        <?php if($_SESSION["isadmin"]):?>
        <li id="adminTab"><a href="">Admin</a>
            <div>
                <ul>
                    <li><a href="addgame.php">Add Game</a></li>
                    <li><a href="deletegame.php">Delete Game</a></li>
                    <li><a href="inactivegame.php">Inactive Games</a></li>
                    <!-- <li><a href="usermgmt.php">User Management</a></li> -->
                </ul>
            </div>
        </li>
     	<?php endif;?>
    </ul>
</nav>
