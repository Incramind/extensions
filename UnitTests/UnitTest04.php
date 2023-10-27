<?php

phpInclude("UnitTest_check.php");

Start("04", "testing types and conversions");

// date 
$leave = new UserLeave();
$dateObj = $leave->LeaveDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "01/01/0001", "date (0)", "empty property not correct");


$leave->SetLeaveDate("20 jan 2021");
$dateObj = $leave->LeaveDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "20/01/2021", "date (1)", "date property not correct");

$dateObj = $leave->GetLeaveDate();
$str = $dateObj->Format("d/m/Y");
Check($str, "20/01/2021", "date (2)", "date getter not correct");

$leave->LeaveDate = "25 feb 2021";
$dateObj = $leave->LeaveDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "25/02/2021", "date (3)", "date set with string not correct");

$leave->LeaveDate = mktime(0, 0, 0, 3, 26, 2021);
$dateObj = $leave->LeaveDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "26/03/2021", "date (4)", "date set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28');
$leave->LeaveDate = $dateObj2;
$dateObj = $leave->LeaveDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "28/04/2021", "date (5)", "date set with object not correct");

// time

$val1 = $leave->FromTime;
Check($val1, 0, "time (0)", "empty property should be 0");

$leave->SetFromTime(600);
$val1 = $leave->FromTime;
Check($val1, 600, "time (1)", "time property not correct");

$val1 = $leave->GetFromTime();
Check($val1, 600, "time (2)", "time getter not correct");

$leave->FromTime = "10:28";
$val1 = $leave->FromTime;
Check($val1, 37680, "time (3)", "time set with string not correct");

$leave->FromTime = mktime(10, 28, 30, 3, 26, 2021);
$val1 = $leave->FromTime;
Check($val1, 37710, "time (4)", "time set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28 10:29');
$leave->FromTime = $dateObj2;
$val1 = $leave->FromTime;
Check($val1, 37740, "time (5)", "time set with datetime object not correct");

$leave->FromTime = "10:28:08pm";
$val1 = $leave->FromTime;
Check($val1, 80888, "time (6)", "time set with string containing PM not correct");

// string
$user = new User();

$str = $user->WelcomeMsg;
Check($str, "", "string (0)", "not set should return empty");

$user->SetWelcomeMsg("Hi there!");
$str = $user->WelcomeMsg;
Check($str, "Hi there!", "string (1)", "string setter");

$user->WelcomeMsg = "Hi there also!";
$str = $user->WelcomeMsg;
Check($str, "Hi there also!", "string (2)", "string set property");

$str = $user->GetWelcomeMsg();
Check($str, "Hi there also!", "string (3)", "string getter");

$user->WelcomeMsg = false;
$str = $user->WelcomeMsg;
Check($str, "No", "string (4)", "string set property with boolean");

$user->WelcomeMsg = 13;
$str = $user->WelcomeMsg;
Check($str, "13", "string (5)", "string set property with integer");

$user->WelcomeMsg = 1.234;
$str = $user->WelcomeMsg;
Check($str, "1.234", "string (6)", "string set property with double");


// boolean

$b1 = $user->Active;
Check($b1, false, "boolean (0)", "not set should return false");

$user->SetActive(true);
$b1 = $user->Active;
Check($b1, true, "boolean (1)", "boolean setter");

$user->Active = false;
$b1 = $user->Active;
Check($b1, false, "boolean (2)", "boolean set property");

$b1 = $user->GetActive();
Check($b1, false, "boolean (3)", "boolean getter");

// long

$int1 = $user->DashboardRows;
Check($int1, 0, "integer (0)", "not set should return 0");

$user->SetDashboardRows(5);
$int1 = $user->DashboardRows;
Check($int1, 5, "integer (1)", "integer setter");

$user->DashboardRows = 10;
$int1 = $user->DashboardRows;
Check($int1, 10, "integer (2)", "integer set property");

$int1 = $user->GetDashboardRows();
Check($int1, 10, "integer (3)", "integer getter");

// double

$rating = new RatingCode();
$d1 = $rating->Weight;
Check($d1, 0, "double (0)", "not set should return 0");

$rating->SetWeight(5.5);
$d1 = $rating->Weight;
Check($d1, 5.5, "double (1)", "double setter");

$rating->Weight = 3.1415927;
$d1 = $rating->Weight;
Check($d1, 3.1415927, "double (2)", "double set property");

$d1 = $rating->GetWeight();
Check($d1, 3.1415927, "double (3)", "double getter");




// reference
$lan1 = $user->Language;
Check($lan1, NULL, "reference (0)", "not set should return 0");

$user->SetLanguage(5);
$lan1 = $user->Language;
Check($lan1->GetId(), 5, "reference (1)", "reference setter");

$user->Language = 10;
$lan1 = $user->Language;
Check($lan1->Getid(), 10, "reference (2)", "reference set property");

$lan1 = $user->GetLanguage();
Check($lan1->GetId(), 10, "reference (3)", "reference getter");

// enum


$enum1 = $user->ChatStatus;
Check($enum1, 0, "enum (0)", "not set should return 0 (unknown)");

$user->SetChatStatus(ChatStatusType_Away);
$enum1 = $user->ChatStatus;
Check($enum1, ChatStatusType_Away, "enum (1)", "enum setter");

$user->ChatStatus = ChatStatusType_Offline;
$enum1 = $user->ChatStatus;
Check($enum1, ChatStatusType_Offline, "enum (2)", "enum set property");

$enum1 = $user->GetChatStatus();
Check($enum1, ChatStatusType_Offline, "enum (3)", "enum getter");

$user->ChatStatus = "Busy";
$enum1 = $user->ChatStatus;
Check($enum1, ChatStatusType_Busy, "enum (4)", "enum setter with string does not work");

$user->ChatStatus = 6;
$enum1 = $user->ChatStatus;
Check($enum1, ChatStatusType_Invisible, "enum (5)", "enum setter with integer does not work");


// datetime

$thread = new Thread();
$dateObj = $thread->Created;
$str = $dateObj->Format("d/m/Y");
Check($str, "01/01/0001", "date (0)", "empty property not correct");

$thread->SetCreated("20 jan 2021  21:22:23");
$dateObj = $thread->Created;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "20/01/2021 21:22:23", "datetime (1)", "datetime property not correct");

$dateObj = $thread->GetCreated();
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "20/01/2021 21:22:23", "datetime (2)", "datetime getter not correct");

$thread->Created = "25 feb 4233  22:23:24";
$dateObj = $thread->Created;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "25/02/4233 22:23:24", "datetime (3)", "datetime set with string not correct");

$thread->Created = mktime(12, 24, 36, 3, 26, 1274);
$dateObj = $thread->Created;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "26/03/1274 12:24:36", "datetime (4)", "datetime set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28 11:04:17');
$thread->Created = $dateObj2;
$dateObj = $thread->Created;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "28/04/2021 11:04:17", "datetime (5)", "datetime set with object not correct");


// store view string

$faq = new Faq();

$str = $faq->Question;
Check($str, "", "string (0)", "not set should return empty");


$faq->SetQuestion("Hi there!");
$str = $faq->Question;
Check($str, "Hi there!", "storeviewstring (1)", "string setter");

$faq->Question = "Hi there also!";
$str = $faq->Question;
Check($str, "Hi there also!", "storeviewstring (2)", "string set property");

$str = $faq->GetQuestion();
Check($str, "Hi there also!", "storeviewstring (3)", "string getter");

$faq->Question = false;
$str = $faq->Question;
Check($str, "No", "storeviewstring (4)", "storeviewstring set property with boolean");

$faq->Question = 13;
$str = $faq->Question;
Check($str, "13", "storeviewstring (5)", "string set property with integer");


$faq->Question = 1.234;
$str = $faq->Question;
Check($str, "1.234", "storeviewstring (6)", "string set property with double");

$faq->SetQuestion("Hi there, store view 4!", 4);
$str = $faq->Question;
Check($str, "1.234", "storeviewstring (7)", "string should not have changed");

$str = $faq->GetQuestion(4);
Check($str, "Hi there, store view 4!", "storeviewstring (8)", "string retrieved for the right storeview");

$faq2 = new Faq();

$faq2->SetQuestion("Hallo in storeview 3", 3);
$str = $faq2->GetQuestion();
Check($str, "Hallo in storeview 3", "storeviewstring (9)", "getting from other storeview should work");

$str = $faq2->GetQuestion(0);
Check($str, "Hallo in storeview 3", "storeviewstring (10)", "getting from storeview 0 should work");

$str = $faq2->GetQuestion(7);
Check($str, "Hallo in storeview 3", "storeviewstring (11)", "getting from storeview N should work");

$faq2->SetQuestion("Hallo in storeview 7", 7);
$str = $faq2->GetQuestion(3);
Check($str, "Hallo in storeview 3", "storeviewstring (12)", "getting from storeview 3 when other is set should work");

$str = $faq2->GetQuestion(7);
Check($str, "Hallo in storeview 7", "storeviewstring (13)", "getting from storeview 7 when other is set should work");



// INcraColor

$theme = new Theme();
$cstr = $theme->BackGroundColor;
Check($cstr, 0, "color (0)", "not set should return 0");

$theme->SetBackGroundColor(255);
$cstr = $theme->BackGroundColor;
Check($cstr, "#0000ff", "color (1)", "color setter");

$theme->BackGroundColor = 256;
$cstr = $theme->BackGroundColor;
Check($cstr, "#000100", "color (2)", "color set property");

$cstr = $theme->GetBackGroundColor();
Check($cstr, "#000100", "color (3)", "color getter");

$theme->BackGroundColor = "red";
$cstr = $theme->BackGroundColor;
Check($cstr, "#ff0000", "color (4)", "color setter with name string does not work");

$theme->BackGroundColor = "#8040a0";
$cstr = $theme->BackGroundColor;
Check($cstr, "#8040a0", "color (5)", "color setter with #color string does not work");





Stop();

?>