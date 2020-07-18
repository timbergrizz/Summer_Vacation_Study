<?php
require_once("../lib/default.php");

$filtered = filterSQL($_POST, $conn);
$arg = "password";
$buf = array($arg => $filtered[$arg]);

$sql = query(2, 1, $buf);
$result = query_return_arr($conn, $sql);

if($filtered[$arg."F"] != $result[$arg]){
    $message = "The Old Password You Have Entered Is Incorrect.";
    errorScriptExe($message);
}
else if($filtered[$arg] != $filtered[$arg."C"]){
    $message = "Password Confirmation Doesn\'t Match Password";
    errorScriptExe($message);
}

$sql = query(3, 1, $buf).where("user", $_SESSION["user_id"]);
$result = mysqli_query($conn, $sql);

if($result){
    $message = "Password Successfully Changed. Move To Main Page";
    $script = messageScript($message, "index");
    echo $script;
}
?>