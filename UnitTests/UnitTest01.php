<?php

phpInclude("UnitTest_check.php");

Start("01", "Basic get/set add/delete");

// we crate a new user class to work with
$u = new User();

// we check if the class is created, and has a good ID
Check($u->Id>0, true, "created ID", "a new class has an ID > 0");

// now we check 3 ways of accessing properties
$u->UserName = "UnitTest";
Check($u->UserName, "UnitTest", "->get", "Checking on the get property");
Check($u->GetUserName(), "UnitTest", "get()", "Checking on the get function");
Check($u['UserName'], "UnitTest", "get[index]", "Checking on the get property via array");

$u->FullName = "Test user";

echo $u;
$str = (string)$u;
echo $str;

// we add the user and check it is is really added
$website->AddUser($u);
$ucopy = $website->GetUser($u->Id);
Check($ucopy->Id, $u->Id, "Get(id)", "Checking if you can get an added record");

// we create dome dash board definitions and place it under that user
$ud1 = new UserDashBoard();
$ud1->index = 1;
$ud1->span = "Week";
$u->AddDashboardDefinition($ud1);

$ud2 = new UserDashBoard();
$ud2->index = 2;
$ud2->span = "Month";
$u->AddDashboardDefinition($ud2);

$ud3 = new UserDashBoard();
$ud3->index = 3;
$ud3->span = "Year";
$u->AddDashboardDefinition($ud3);

$ud4 = new UserDashBoard();
$ud4->index = 4;
$ud4->span = "Day";
$u->AddDashboardDefinition($ud4);

// we check if get all works, and they are all added
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 4, "GetAll()", "Checking if you can get all the records");

// check if we can find one
$hud = $u->FindDashboardDefinition("span", "Year");
Check($hud->id, $ud3->Id, "Find()", "Finding a record");

// check if we can filter 1
$defs = $u->GetFilteredDashboardDefinitions("index", "1");
$nr = sizeof($defs);
Check($nr, 1, "GetFiltered()", "Checking if you can get filtered records");
Check($defs[0]->Id, $ud1->id, "GetFiltered()", "Checking if you can get filtered records, right ID");

$defs = $u->GetFilteredDashboardDefinitions("index", "> 1", "span");
$nr = sizeof($defs);
Check($nr, 3, "GetFiltered(sort)", "Checking if you can get filtered records with > expression");
Check($defs[0]->Id, $ud4->id, "GetFiltered() sort", "Checking if you sort works");

$filter = array("index" => "> 1", "span" => "e");
$defs = $u->GetFilteredDashboardDefinitions($filter);
$nr = sizeof($defs);
Check($nr, 1, "GetFiltered(array)", "Checking if you can get filtered records with > expression");
Check($defs[0]->Id, $ud3->id, "GetFiltered() sort", "Checking if right ID");

// checking on the delete
$u->DeleteDashboardDefinition($ud3->id);
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 3, "Delete(id)", "Checking if the item is really deleted");

$u->DeleteDashboardDefinition($ud2);
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 2, "Delete(obj)", "Checking if the item is really deleted");

$u->ClearDashboardDefinitions();
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 0, "Clear()", "Checking if the item is really cleared");

Stop();


?>