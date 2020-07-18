<?php
require_once("../lib/default.php");

$filtered = filterSQL($_POST, $conn);

$script = "";
$notNull = array(
    "user_id" => "ID",
    "password" => "Password",
    "nickname" => "Nickname"
);

nullCheck($filtered, $notNull);

$sql = query(2, 1, $notNull)."where user_id = {$filtered['id']}";
$result = query_return_arr($conn, $sql);

if(isset($result["user_id"]))
    ErrorScript("ID Already Exist. Please Choose Another ID");

$sql = query(1, 1, $keys)."(user_id, password, nickname, profile)
values('".$filtered["user_id"]."', '".$filtered["password"]."', '".$filtered["nickname"]."', '".$filtered["profile"]."')";

$result = mysqli_query($conn, $sql);
if($result){
    $message = "ID Successfully Created. Move To Login Page";
    $script = messageScript($message, "login");
    echo $script;
}
?>