<?php

phpInclude("UnitTest_check.php");

Start("02", "Error cases add and delete");

// we create a new user class to work with
$u = new User();
$u2 = new User();

// we create some dash board definitions and place it under that user
$ud1 = new UserDashBoard();
$ud1->index = 1;
$ud1->span = "Week";
$ret = $u->AddDashboardDefinition($ud1);
Check($ret, true, "Adding 2x (a)", "Checking if you are allowed to add the same record twice");
$ret = $u->AddDashboardDefinition($ud1);
Check($ret, false, "Adding 2x (b)", "Checking if you are allowed to add the same record twice");
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 1, "Adding 2x (c)", "Checking if you are allowed to add the same record twice");

$ret = $u2->AddDashboardDefinition($ud1);
Check($ret, false, "Adding invalid (a)", "Checking if you are allowed to add the same record to another object");
$defs = $u2->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 0, "Adding invalid (b)", "Checking if you are allowed to add the same record to another object");


$uleave = new UserLeave();
$ret = $u->AddDashboardDefinition($uleave);
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($ret, false, "Wrong add (a)", "Checking if you are allowed to add a wrong object");
Check($nr, 1, "Wrong add (b)", "Checking if you are allowed to add a wrong object");

$ret1 = $u->DeleteDashboardDefinition($ud1);
$ret2 = $u->DeleteDashboardDefinition($ud1);
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($ret1, true, "deleting twice (a)", "Checking if you are allowed to delete a record twice");
Check($ret2, false, "deleting twice (b)", "Checking if you are allowed to delete a record twice");
Check($nr, 0, "deleting twice (c)", "Checking if you are allowed to delete a record twice");


Check($ud1->span, "Week", "access deleted", "accessing a deleted object is OK");
$ud1->span = "new year";
Check($ud1->span, "Week", "modify deleted", "Modifying a deleted object is NOT OK");

$u->AddDashboardDefinition($ud1);
$defs = $u->GetAllDashboardDefinitions();
$nr = sizeof($defs);
Check($nr, 0, "add deleted", "Checking if you are allowed to add a delete record");

Stop();


?>