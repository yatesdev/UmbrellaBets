
 <?php
 include_once "./php/db.php";
$sql="SELECT username FROM Users";
$result=mysql_query($sql);
$num_rows = mysql_num_rows($result);

for($row_num = 1; $row_num <= $num_rows; $row_num++){
		$row_array = mysql_fetch_array($result);
		$arr[]=$row_array['username'];
	}

/*Posts Ajax parameter name*/	
$username=$_POST["name"];

if((in_array($username, $arr)==false) && ($username!=''))
{
	$response="<img class='avail' src='./img/tick.png'>available";
	
	
}
else if(in_array($username, $arr)){
	$response="<img class= 'taken' src='./img/invalid.png'>unavailable";
 
}
 else{
	$response="";
} 
echo $response;
?>
  <!-- Created by: Kimberly Lanman
	Description: Accesses the Users table from the database and checks if username 
	typed in newaccount.php is available for use
	-->
 