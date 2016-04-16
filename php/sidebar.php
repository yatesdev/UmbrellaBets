<?php
    include_once "db.php";
    print('<ul>');
    $getcategories = "SELECT DISTINCT category FROM Games WHERE status = 'Active' ORDER BY category";
    $categories = mysql_query($getcategories);
    if(! $categories){
        die('Invalid query: ' . mysql_error());
        exit;
    }
    $numrows = mysql_num_rows($categories);
    for($rownum =1;$rownum <= $numrows;$rownum++){
        $row = mysql_fetch_array($categories);
        print('<li><a href="games.php'.'?category='.$row["category"].'">'.$row["category"].'</a></li>');
    }
    print('</ul>');
?>
<!--Mike Yates
  This page is the template for the sidebar, which is called on all pages-->