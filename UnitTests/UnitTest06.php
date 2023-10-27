<?php

phpInclude("UnitTest_check.php");

Start("06", "Array access and vardump");

$user = new User();

$user->UserName = "Dennis";

$tmp = $user["UserName"];
Check($tmp, "Dennis", "array get 1", "retrieved with []");

$user["UserName"] = "Jaap";
Check($user->UserName, "Jaap", "array set 1", "setting with []");

$b1 = isset($user["userName"]);
$b2 = isset($user["userName2"]);
Check($b1, true, "array isset 1", "if property exists");
Check($b2, true, "array isset 2", "if property not exists");

unset($user["userName"]);
Check($user->UserName, "", "array unset 1", "unsetting should clear the value (what else)");

$cnt = 0;
foreach($user as $a => $b)
{
  $cnt++;
  //echo "$a : $b ...";
  if ($cnt==1)
  {
	Check($a, "Id", "foreach 1", "first element is ID");
  }
  if ($cnt==2)
  {
	Check($a, "UserName", "foreach 2", "second element is username");
	Check($a, "Dennis", "foreach 3", "value of second element is dennis");
  }
}

$nr = count($user);
Check($nr, 35, "count 1", "counting all the proeprties of user");

var_dump($user);

varDumpEx($user);



Stop();


?>