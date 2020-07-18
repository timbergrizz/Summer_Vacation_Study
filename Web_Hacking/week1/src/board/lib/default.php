<?php
require_once("functions.php");
$host = "db";
$user = 'root';
$password = 'root';
$db = 'board_db';
$conn = mysqli_connect($host, $user, $password, $db);
if(!$conn){
  echo 'connection failed';
}

session_start();
?>