<?php
require_once("../lib/default.php");

$filtered = filterSQL($_POST, $conn);

if(isset($filtered["comment"])){
    $type = "comment";
    $typeNum = 3;
    $arg = array("comment" => $filtered["comment"]);
}
else {
    $type = "article";
    $typeNum = 2;
    $arg = array(
        "title" => $filtered["title"],
        "content" => $filtered["article"]
    );
}

$sql = query(3, $typeNum, $arg).where($type, $filtered[$type."_id"]);
$result = mysqli_query($conn, $sql);
sqlFailureCheck($result);

$script = messageScript("Successfully Edited", "view.php?article_id=".$filtered["article_id"]);
echo $script;
?>