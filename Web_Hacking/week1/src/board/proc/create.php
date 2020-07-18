<?php
    require_once("../lib/default.php");

    loginCheck($_SESSION["user_id"]);
    $filteredGet = filterSQL($_GET, $conn);

    $filtered = filterSQL($_POST, $conn);
    $filtered["user_id"] = mysqli_real_escape_string($conn, $_SESSION["user_id"]);

    if($filteredGet["type"] == "article" || $filteredGet["type"]=="2"){
        $type = "article";
        $notNull = array("title" => "Title", "content" => "Content"); 
        nullCheck($filtered, $notNull);
        $sql = query(1, 2, $filtered);
        $page = "board";
    }
    else if($filteredGet["type"] == "3"){
        $type = "comment";
        $parameter = array("comment"=>"Comment");
        nullCheck($filtered, $parameter);
        $sql = query(1, 3, $filtered);
    } 

    if(!(mysqli_query($conn, $sql))){
        die("Failed to create comment. Ask for manager <a href='index.php'>Return Home</a>");
    }else{    
        pointAdd($conn, $_SESSION["user_id"], $type);
        if($type == "article") messageScriptExe("savesuc", $page, 1);
        else errorScriptExe(messages("savesuc"));
    }
    
?>