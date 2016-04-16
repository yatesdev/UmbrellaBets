<?php
    //This library I added because UMBC is using a 13 year old version of PHP that doesnt support JSON easily
    function startDB(){#Connect to database
        $db = mysql_connect("studentdb.gl.umbc.edu","yates2","yates2");
        if(!$db)
            exit("Error - could not connect to MySQL");

        #select database yates2
        $er = mysql_select_db("yates2");
        if(!$er)
            exit("Error - could not select database");
    }
    //error_reporting(0);
    startDB();
?>