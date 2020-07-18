<?php
require_once("../lib/default.php");

$filtered = filterSQL($_POST, $conn);   // POST 입력값 escaping

$notNull = array("user_id" => "ID", "password" => "Password");  // 공백 체크 대상 확인
nullCheck($filtered, $notNull); // 공백 체크. 공백 있으면 여기서 정지

$sql = query(2, 1, $notNull).where("user", $filtered["user_id"]);
$result = query_return_arr($conn, $sql); // 쿼리 전달

if(!isset($result['user_id'])) loginErrorScript("id"); // id 존재 안하는 경우
else if ($result["password"] != $filtered["password"]) loginErrorScript("password"); // 비밀번호 일치하지 않는 경우

$_SESSION["user_id"] = $result["user_id"]; // default에서 세션이 시작되어 있으므로, 세션 등록만.
redirect("index");
?>