<?php
require_once("../lib/default.php");
$filtered = filterSQL($_POST, $conn);

authentication($_SESSION["user_id"], $filtered["id"], $conn, $filtered["type"]);
if($filtered["type"] == "article") $type = 2;
else $type = 3;

$dummy = array();
$sql = query(4, $type, $dummy)." ".where($filtered["type"], $filtered["id"]);

$result = mysqli_query($conn, $sql);
sqlFailureCheck($result);

messageScriptExe("remove", "board", 1);
?>