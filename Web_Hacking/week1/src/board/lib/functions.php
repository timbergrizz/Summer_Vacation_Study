<?php
function query_return_arr($conn, $sql){

    $result = mysqli_query($conn, $sql);
    sqlFailureCheck($result);
    $result_arr = mysqli_fetch_array($result);

    return $result_arr;
}

function sqlFailureCheck($res){
   if(!$res){
     $message = "Save Failed. Ask For Administrator.";
     errorScriptExe($message);
   }
}

function loginCheck($sessionid){
  if(!isset($sessionid))
    accessDeny(true, false);
}

function loginCheckNoProc($session){
  if(!isset($session)){
    $message = messages("access");
    $script = messageScriptNoProc($message, "index");
    echo $script;
  }
}

function authentication($session, $id, $conn, $aorc){ // aorc -> a is article, c is comment;
  $sql = "select user_id from {$aorc} where {$aorc}_id = ".$id;
  $result = query_return_arr($conn, $sql);

  accessDeny($session, $result["user_id"]);
}

function accessDeny($target, $buf){
  if($target != $buf){ // certificate user_id
    $message = messages("access");
    $script = messageScript($message, "index");
    die($script);
  }
}

function messages($type){
  $message = array(
    "access" => "Access Denied. Return To Home",
    "alreadylogged" => "You Already Logged In. Move To Main Page",
    "savesuc" => "Succefully Saved.",
    "remove" => "Succesfully Removed. Return To List"
  );
  return $message[$type];
}

function ErrorScript($message){ //move to back
  $script = "<script> alert('".$message."');
  window.history.back();
  </script>
  ";
  return $script;
}

function errorScriptExe($message){
  $script = ErrorScript($message);
  die($script);
}
function messageScript($message, $page){ // move to certain page
  $script = "
  <script>
    alert('{$message}');
    window.location.href = '../{$page}.php';
  </script> 
  ";
  return $script;
}

function messageScriptNoProc($message, $page){
  $script = "
  <script>
    alert('{$message}');
    window.location.href = './{$page}.php';
  </script> 
  ";
  return $script;
}

function messageScriptExe($messageType, $page, $proc){
  $message = messages($messageType);
  if($proc = 1) $script = messageScript($message, $page);
  else if($proc = 0) $script = messageScriptNoProc($message, $page);
  echo $script;
}

function loginErrorScript($errorType){
  $error = loginError($errorType);
  $script = ErrorScript($error);
  die($script);
}

function filterSQL($arr, $conn){
$filtered = array();

  foreach($arr as $key => $value){
    $buffer = mysqli_real_escape_string($conn, $value);
    $filtered[$key] = $buffer;
  }
  return $filtered;
}


function filterXSS($arr){
  $filtered = array();
    foreach($arr as $key => $value){
      $buffer = htmlspecialchars($value);
      $filtered[$key] = $buffer;
    }
    return $filtered;
  }

function nullCheck($resultArr, $keyArr){
  foreach($keyArr as $key => $value){
   if(!$resultArr[$key]){
     $message = "Enter ".$value;
     $script = ErrorScript($message); 
     die($script);
    }
  }
}

function redirect($page){
  $link = "Location: ../".$page.".php";
  header($link);
}

function loginError($error){
    if($error == "id")
      return "Login Failed. Please Check Your ID";
    else if($error == "password")
      return "Login Failed. Please Check Your Password";
  }
  
function queryFin($str){
    $str = substr($str, 0, -2);
    $str .= " ";

    return $str;
  }

function queryPar($keys){
    $result = "";
    foreach($keys as $key=>$value){
      $result .= $key.", ";
    }
    $result = queryFin($result);
    return $result;
  }
  
  function queryParEdit($arr){
    $result = "";
    foreach($arr as $key => $value){
      $result .= $key." = '".$value."', ";
    }
    $result = queryFin($result);
    return $result;
  }

function queryValue($keys){
  $result = "";
  foreach($keys as $key=>$value){
    $result .= "'".$value."', ";
  }
  $result = queryFin($result);
  return $result; 
}

function tableType($type){
  $tableName = array(
    1 => "user", 2 => "article", 3 => "comment"
  ); 
  return $tableName[$type];
}

function query($type, $table, $keys){
  $tableName = tableType($table);

  $typeStr = array(
    1 => "insert into {$tableName} (".queryPar($keys).") values(".queryValue($keys).")",
    2 => "select ".queryPar($keys)."from ".$tableName." ",
    3 => "update {$tableName} set ".queryParEdit($keys),
    4 => "delete from {$tableName}"
  );
  return $typeStr[$type];
}


function where($type, $id){
  $str ="where {$type}_id = '{$id}'";
  return $str;
}

function pointAdd($conn, $session, $addType){
  if($addType == "article") $pointAddition = 100;
  else if ($addType =="comment") $pointAddition = 50;
  $dummy = array();

  $sql = query(3, 1, $dummy)." point = point + ".$pointAddition." ".where("user",$session);
  $result = mysqli_query($conn, $sql);

  sqlFailureCheck($result);
}

function hrefArg($keys){
  $result = "";
  foreach($keys as $key=>$value){
    $result .= $key."=".$value."&";
  }
  $result .= " ";
  $result = queryFin($result);
  return $result;
}

function href($link, $arg, $message){
  $par = hrefArg($arg);
  $script = "<a href=".$link."?".$par.">{$message}</a>";

  return $script;
}

function tableFrame($arr){
  $tableScript = "<tr>";
  foreach($arr as $key => $value){
    $tableScript .= "<th>{$value}</th>";
  }
  $tableScript .= "</tr>";
  return $tableScript;
}

function tableValue($arr, $id = null){
  if(!isset($arr["comment_id"])){
    $hrefStart = "<a href='view.php?article_id={$arr['article_id']}'>";
    $hrefEnd = "</a>";
  }
  else{
    $arr["button"] = accessButton($id, $arr["user_id"], 3, $arr["comment_id"]);
  }

  $tableScript = "<tr>";
  foreach($arr as $key => $value){
    $valueWithLink = $hrefStart.$value.$hrefEnd;
    $tableScript .= "<td>{$valueWithLink}</a></td>";
  }
  $tableScript .= "</tr>";

  return $tableScript;
}

function tableBuild($arg, $result, $id = null){
  $tableScript = tableFrame($arg);
  
  while($arr = mysqli_fetch_array($result)){
    $result_arr = array();
    foreach($arg as $key => $value){
      $result_arr[$key] = $arr[$key];
    }
    filterXSS($result_arr);
    $tableScript .= tableValue($result_arr, $id);
  }
  return $tableScript;
}

function page($type, $conn){
  $dummy = array("count(*)" => "");
  $sql = query(2, $type, $dummy);

  $result = query_return_arr($conn, $sql);
  $pageCount = ($result["count(*)"] / 10) + 1;

  $pageScript = "";
  for($i = 1; $i <= $pageCount; $i += 1){
    $arg = array("page" => $i);
    $pageScript .= href("board.php", $arg, $i)." ";
  }
  return $pageScript;
}

function joinTable($type1, $type2, $idtype){
  $type1 = tableType($type1);
  $type2 = tableType($type2);

  $query = "left join {$type2} on {$type1}.{$idtype}_id = {$type2}.{$idtype}_id ";
  return $query;
}

function accessButton($session, $writer, $type, $id){
  $result = "";
  $type = tableType($type);
  $par = array("type" => $type, "id" => $id);
  $updateHref = href("update.php", $par, "Edit");
  if($session == $writer){
      $result .= ' <form action="proc/delete.php" method="post">
                  <input type="hidden" name="type" value="'.$type.'">
                  <input type="hidden" name="id" value="'.$id.'">
                  <input type="submit" value="delete">
                  '.$updateHref.'
                  </form>';
  }
  return $result;
}
?>