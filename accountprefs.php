<?php include_once  "./php/db.php";
            session_start();
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];?>  
<html>
      
    <head>
       
        <title>
            Account Preferences
        </title>
		<script type="text/javascript" src=" http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js "></script>
		<script type = "text/javascript" src="./javascript/verifyForm.js"></script>
        <link rel="stylesheet" type="text/css" href="home.css">
    </head>
    <body>
       <div class="header">
        <?php include "./php/header.php";?>
        </div>
        <div class="wrapper">
            <div class="sidebar">
                <?php include "./php/sidebar.php";?>
            </div>
            <h4>Account Preferences</h4>           
            <?php
                $usrID=$_SESSION['uid'];
                $query="SELECT* from Users where userID = '$usrID'"; 
                $result=mysql_query($query);
                $numrows = mysql_num_rows($result);
                for($rownum =1;$rownum <= $numrows;$rownum++){
                    $row = mysql_fetch_array($result);
                }
                if($row['userID'] != 1):
                ?>
                    <div class = "newform">
                        
                        <form id= "pwchange" name = "pwchange" action="updatepassword.php" method = "post" onsubmit="return changePW()">
                        <fieldset class="logindata">
                            <legend>Change Password</legend>
                            <table>
                                <tr>
                                    <td class="label"><label>Current Password</label></td>
                                    <td class="field"><input type="password" id="currpw" name="currpw" required /></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>New Password</label></td>
                                    <td class="field"><input type="password" id="pw" name= "pw" required pattern="(?=.*\d)(?=.*[A-z]).{8,}" placeholder="8+ characters and a/least 1 number"/></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>Confirm Password</label></td>
                                    <td class="field"><input type="password" id="cpw" name= "cpw" required pattern="(?=.*\d)(?=.*[A-z]).{8,}" onkeyup="checkPW(this.value)"/><span id="confirmpw"></span></td>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset class="buttons"> 
                            <input type="submit" id="changepw" name="changepw" value="Submit" />
                            <input type ="reset" value ="Reset"/>
                         </fieldset>
                        </form> 
                        <br />
                    </div>
                    <div class="newform" style="vertical-align:top;">
                        <form id= "emailchange" name = "emailchange" action="updateEmail.php" method = "post" onsubmit="return checkEmail()">
                            <fieldset class="logindata">
                            <legend>Change Email</legend>
                                <table>
                                <!--<tr>
                                    <td class="label"><label>Current Email</label></td>
                                    <td class="field"><input type="text" id="curremail" name= "curremail" required/></td>
                                </tr>-->
								<tr>
                                    <td class="label"><label>Username</label></td>
                                    <td class="field"><input type="text" id="username" name="username" required/></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>Password</label></td>
                                    <td class="field"><input type="password" id="pw" name="pw" required/></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>New Email</label></td>
                                    <td class="field"><input type = "text" id="email" name = "email" required pattern="([\w\-]+\@[\w\-]+\.[\w\-]+)" placeholder="jdoe@domain.example" /></td>
                                </tr>
                                
                                </table>
                            </fieldset>
                            <fieldset class="buttons">
                                <input type="submit" name="emlchange" id="emlchange" value="Submit"/>
                            
                                <input type ="reset" value ="Reset"/>
                            </fieldset>
                        </form> 
                        </div>
            <?php else:?>
                <p>As the default admin, these settings are unavailable.</p>          
            <?php endif;?>
        </div>
    </body>
    <footer>
    <?php include "./php/footer.php";?>
	</footer>
</html>
<!--Author: Kimberly Lanman
Description: This is the account preferences php file. It contains options for a user that wants to change their email or password or can't 
remember their username and/or password . -->

