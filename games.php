<?php 
    include_once "./php/db.php";
    session_start();
    //<!--Mike Yates
    //This pages shows all of the active games if no category is selected. If a category is selected from the sidebar, then the list of games is filtered. -->
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    $category = "";
    if(isset($_GET["category"]))
        $category = $_GET["category"];
?>
<html>
<head>
    <title>Games</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" href="./img/favicon.png">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="./javascript/ajax.js"></script>
    <script>
        $(document).ready(function(){
            GamesAjax(<?php echo '\''.$category.'\''?>);
        })
    </script>
</head>

<body>
    <div class="header">
        <?php include "./php/header.php";?>
    </div>
    <div class="wrapper">
        <div class="sidebar"></div>
        <div class="maincontent">
        <div id="fillGames"></div>
    </div>
</body>
<footer>
    <?php include "./php/footer.php";?>
</footer>

</html>
