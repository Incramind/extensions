<?php

phpInclude("UnitTest_check.php");

Start("08", "types for extension of tables");

customTableAddField("User", "ExtraBool",  REPLACER_TYPE_BOOLEAN, "A additional field for testing bool values");
customTableAddField("User", "ExtraLong",  REPLACER_TYPE_INTEGER, "A additional field for testing long values");
customTableAddField("User", "ExtraDouble",  REPLACER_TYPE_NUMERIC, "A additional field for testing double values");
customTableAddField("User", "ExtraString",  REPLACER_TYPE_STRING, "A additional field for testing string values");
customTableAddField("User", "ExtraDate",  REPLACER_TYPE_DATE, "A additional field for testing date values");
customTableAddField("User", "ExtraDateTime",  REPLACER_TYPE_DATETIME, "A additional field for testing date and time values");
customTableAddField("User", "ExtraTime",  REPLACER_TYPE_TIME, "A additional field for testing time values");
customTableAddField("User", "ExtraTimeSpan",  REPLACER_TYPE_TIMESPAN, "A additional field for timespan integer values");
customTableAddField("User", "ExtraColor",  REPLACER_TYPE_COLOR, "A additional field for testing color values");
customTableAddField("User", "ExtraAmount",  REPLACER_TYPE_AMOUNT, "A additional field for testing amount values");
customTableAddField("User", "ExtraStoreViewString",  REPLACER_TYPE_STOREVIEW_STING, "A additional field for testing store view string values");
customTableAddField("User", "ExtraReference",  REPLACER_TYPE_REFERENCE, "A additional field for testing reference values", "Language");
customTableAddField("User", "ExtraEnum",  REPLACER_TYPE_ENUM, "A additional field for testing enum values", "ProductType");


$user = new User();


//-------------------
// date 
//-------------------

$dateObj = $user->ExtraDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "01/01/0001", "date (0)", "empty property not correct");


$user->SetExtraDate("20 jan 2021");
$dateObj = $user->ExtraDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "20/01/2021", "date (1)", "date property not correct");

$dateObj = $user->GetExtraDate();
$str = $dateObj->Format("d/m/Y");
Check($str, "20/01/2021", "date (2)", "date getter not correct");

$user->ExtraDate = "25 feb 2021";
$dateObj = $user->ExtraDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "25/02/2021", "date (3)", "date set with string not correct");

$user->ExtraDate = mktime(0, 0, 0, 3, 26, 2021);
$dateObj = $user->ExtraDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "26/03/2021", "date (4)", "date set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28');
$user->ExtraDate = $dateObj2;
$dateObj = $user->ExtraDate;
$str = $dateObj->Format("d/m/Y");
Check($str, "28/04/2021", "date (5)", "date set with object not correct");


//-------------------
// time
//-------------------
$val1 = $user->ExtraTime;
Check($val1, 0, "time (0)", "empty property should be 0");

$user->SetExtraTime(600);
$val1 = $user->ExtraTime;
Check($val1, 600, "time (1)", "time property not correct");

$val1 = $user->GetExtraTime();
Check($val1, 600, "time (2)", "time getter not correct");

$user->ExtraTime = "10:28";
$val1 = $user->ExtraTime;
Check($val1, 37680, "time (3)", "time set with string not correct");

$user->ExtraTime = mktime(10, 28, 30, 3, 26, 2021);
$val1 = $user->ExtraTime;
Check($val1, 37710, "time (4)", "time set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28 10:29');
$user->ExtraTime = $dateObj2;
$val1 = $user->ExtraTime;
Check($val1, 37740, "time (5)", "time set with datetime object not correct");

$user->ExtraTime = "10:28:08pm";
$val1 = $user->ExtraTime;
Check($val1, 80888, "time (6)", "time set with string containing PM not correct");

//-------------------
// string
//-------------------
$str = $user->ExtraString;
Check($str, "", "string (0)", "not set should return empty");

$user->SetExtraString("Hi there!");
$str = $user->ExtraString;
Check($str, "Hi there!", "string (1)", "string setter");

$user->ExtraString = "Hi there also!";
$str = $user->ExtraString;
Check($str, "Hi there also!", "string (2)", "string set property");

$str = $user->GetExtraString();
Check($str, "Hi there also!", "string (3)", "string getter");

$user->ExtraString = false;
$str = $user->ExtraString;
Check($str, "No", "string (4)", "string set property with boolean");

$user->ExtraString = 13;
$str = $user->ExtraString;
Check($str, "13", "string (5)", "string set property with integer");

$user->ExtraString = 1.234;
$str = $user->ExtraString;
Check($str, "1.234", "string (6)", "string set property with double");


//-------------------
// boolean
//-------------------
$b1 = $user->ExtraBool;
Check($b1, false, "boolean (0)", "not set should return false");

$user->SetExtraBool(true);
$b1 = $user->ExtraBool;
Check($b1, true, "boolean (1)", "boolean setter");

$user->ExtraBool = false;
$b1 = $user->ExtraBool;
Check($b1, false, "boolean (2)", "boolean set property");

$b1 = $user->GetExtraBool();
Check($b1, false, "boolean (3)", "boolean getter");

//-------------------
// long
//-------------------
$int1 = $user->ExtraLong;
Check($int1, 0, "integer (0)", "not set should return 0");

$user->SetExtraLong(5);
$int1 = $user->ExtraLong;
Check($int1, 5, "integer (1)", "integer setter");

$user->ExtraLong = 10;
$int1 = $user->ExtraLong;
Check($int1, 10, "integer (2)", "integer set property");

$int1 = $user->GetExtraLong();
Check($int1, 10, "integer (3)", "integer getter");


//-------------------
// double
//-------------------
$d1 = $user->ExtraDouble;
Check($d1, 0, "double (0)", "not set should return 0");

$user->SetExtraDouble(5.5);
$d1 = $user->ExtraDouble;
Check($d1, 5.5, "double (1)", "double setter");

$user->ExtraDouble = 3.1415927;
$d1 = $user->ExtraDouble;
Check($d1, 3.1415927, "double (2)", "double set property");

$d1 = $user->GetExtraDouble();
Check($d1, 3.1415927, "double (3)", "double getter");


//-------------------
// amount
//-------------------
$d1 = $user->ExtraAmount;
Check($d1, 0, "amount (0)", "not set should return 0");

$user->SetExtraAmount(5.50);
$d1 = $user->ExtraAmount;
Check($d1, 5.5, "amount (1)", "amount setter");

$user->ExtraAmount = "$123,456,789.01";
$d1 = $user->ExtraAmount;
Check($d1, 123456789.01, "amount (2)", "amount set property");

$d1 = $user->GetExtraAmount();
Check($d1, 123456789.01, "amount (3)", "amount getter");


//-------------------
// reference
//-------------------

$lan1 = $user->ExtraReference;
Check($lan1, NULL, "reference (0)", "not set should return 0");

$user->SetExtraReference(5);
$lan1 = $user->Extrareference;
Check($lan1->GetId(), 5, "reference (1)", "reference setter");

$user->ExtraReference = 10;
$lan1 = $user->ExtraReference;
Check($lan1->Getid(), 10, "reference (2)", "reference set property");

$lan1 = $user->GetExtraReference();
Check($lan1->GetId(), 10, "reference (3)", "reference getter");

$lan2 = new Language();
$user->ExtraReference = $lan2;
$lan1 = $user->ExtraReference;
Check($lan1->Id, $lan2->Id, "reference (4)", "new id, not correct");

$user->ExtraReference = NULL;
$lan1 = $user->ExtraReference;
Check($lan1, NULL, "reference (5)", "new id, not correct");

$user->ExtraReference = 11;
$lan1 = $user->ExtraReference;
Check($lan1->Getid(), 11, "reference (6)", "reference property 11");

$user->ExtraReference = 0;
$lan1 = $user->ExtraReference;
Check($lan1, NULL, "reference (7)", "setting to 0 should result in NULL");

$user->ExtraReference = 491638737;
$lan1 = $user->ExtraReference;
Check($lan1, NULL, "reference (8)", "none existing ID should result in NULL");


//-------------------
// enum
//-------------------
$enum1 = $user->ExtraEnum;
Check($enum1, 0, "enum (0)", "not set should return 0 (unknown)");

$user->SetExtraEnum(ProductType_Grouped);
$enum1 = $user->ExtraEnum;
Check($enum1, ProductType_Grouped, "enum (1)", "enum setter");

$user->ExtraEnum = ProductType_Configurable;
$enum1 = $user->ExtraEnum;
Check($enum1, ProductType_Configurable, "enum (2)", "enum set property");

$enum1 = $user->GetExtraEnum();
Check($enum1, ProductType_Configurable, "enum (3)", "enum getter");

$user->ExtraEnum = "Simple";
$enum1 = $user->ExtraEnum;
Check($enum1, ProductType_Simple, "enum (4)", "enum setter with string does not work");

$user->ExtraEnum = 6;
$enum1 = $user->ExtraEnum;
Check($enum1, ProductType_Quotable, "enum (5)", "enum setter with integer does not work");


//-------------------
// datetime
//-------------------
$dateObj = $user->ExtraDateTime;
$str = $dateObj->Format("d/m/Y");
Check($str, "01/01/0001", "datetime (0)", "empty property not correct");

$user->SetExtraDateTime("20 jan 2021  21:22:23");
$dateObj = $user->ExtraDateTime;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "20/01/2021 21:22:23", "datetime (1)", "datetime property not correct");

$dateObj = $user->GetExtraDateTime();
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "20/01/2021 21:22:23", "datetime (2)", "datetime getter not correct");

$user->ExtraDateTime = "25 feb 4233  22:23:24";
$dateObj = $user->ExtraDateTime;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "25/02/4233 22:23:24", "datetime (3)", "datetime set with string not correct");

$user->ExtraDateTime = mktime(12, 24, 36, 3, 26, 1274);
$dateObj = $user->ExtraDateTime;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "26/03/1274 12:24:36", "datetime (4)", "datetime set with timestamp not correct");

$dateObj2 = new DateTime('2021-04-28 11:04:17');
$user->ExtraDateTime = $dateObj2;
$dateObj = $user->ExtraDateTime;
$str = $dateObj->Format("d/m/Y H:i:s");
Check($str, "28/04/2021 11:04:17", "datetime (5)", "datetime set with object not correct");


//-------------------
// store view string
//-------------------
$str = $user->ExtraStoreViewString;
Check($str, "", "string (0)", "not set should return empty");


$user->SetExtraStoreViewString("Hi there!");
$str = $user->ExtraStoreViewString;
Check($str, "Hi there!", "storeviewstring (1)", "string setter");

$user->ExtraStoreViewString = "Hi there also!";
$str = $user->ExtraStoreViewString;
Check($str, "Hi there also!", "storeviewstring (2)", "string set property");

$str = $user->GetExtraStoreViewString();
Check($str, "Hi there also!", "storeviewstring (3)", "string getter");

$user->ExtraStoreViewString = false;
$str = $user->ExtraStoreViewString;
Check($str, "No", "storeviewstring (4)", "storeviewstring set property with boolean");

$user->ExtraStoreViewString = 13;
$str = $user->ExtraStoreViewString;
Check($str, "13", "storeviewstring (5)", "string set property with integer");


$user->ExtraStoreViewString = 1.234;
$str = $user->ExtraStoreViewString;
Check($str, "1.234", "storeviewstring (6)", "string set property with double");

$user->SetExtraStoreViewString("Hi there, store view 4!", 4);
$str = $user->ExtraStoreViewString;
Check($str, "1.234", "storeviewstring (7)", "string should not have changed");

$str = $user->GetExtraStoreViewString(4);
Check($str, "Hi there, store view 4!", "storeviewstring (8)", "string retrieved for the right storeview");


$user->SetExtraStoreViewString("Hallo in storeview 3", 3);
$str = $user->GetExtraStoreViewString();
Check($str, "1.234", "storeviewstring (9)", "getting from other storeview should work");

$str = $user->GetExtraStoreViewString(0);
Check($str, "Hallo in storeview 3", "storeviewstring (10)", "getting from storeview 0 should work");

$str = $user->GetExtraStoreViewString(7);
Check($str, "Hallo in storeview 3", "storeviewstring (11)", "getting from storeview N should work");

$user->SetExtraStoreViewString("Hallo in storeview 7", 7);
$str = $user->GetExtraStoreViewString(3);
Check($str, "Hallo in storeview 3", "storeviewstring (12)", "getting from storeview 3 when other is set should work");

$str = $user->GetExtraStoreViewString(7);
Check($str, "Hallo in storeview 7", "storeviewstring (13)", "getting from storeview 7 when other is set should work");



//-------------------
// INcraColor
//-------------------
$cstr = $user->extraColor;
Check($cstr, 0, "color (0)", "not set should return 0");

$user->SetextraColor(255);
$cstr = $user->extraColor;
Check($cstr, "#0000ff", "color (1)", "color setter");

$user->extraColor = 256;
$cstr = $user->extraColor;
Check($cstr, "#000100", "color (2)", "color set property");

$cstr = $user->GetextraColor();
Check($cstr, "#000100", "color (3)", "color getter");

$user->extraColor = "red";
$cstr = $user->extraColor;
Check($cstr, "#ff0000", "color (4)", "color setter with name string does not work");

$user->extraColor = "#8040a0";
$cstr = $user->extraColor;
Check($cstr, "#8040a0", "color (5)", "color setter with #color string does not work");



//-------------------
// timespan
//-------------------
$cstr = $user->ExtraTimeSpan;
Check($cstr, 0, "timespan (0)", "not set should return 0");

$user->SetExtraTimeSpan(1000);
$cstr = $user->ExtraTimeSpan;
Check($cstr, 1000, "timespan (1)", "timespan setter");

$user->ExtraTimeSpan = 2000;
$cstr = $user->ExtraTimeSpan;
Check($cstr, 2000, "timespan (2)", "timespan set property");

$cstr = $user->GetExtraTimeSpan();
Check($cstr, 2000, "timespan (3)", "timespan getter");

$user->ExtraTimeSpan = "10:20";
$cstr = $user->ExtraTimeSpan;
Check($cstr, 620, "timespan (4)", "timespan setter with string does not work");

$user->ExtraTimeSpan = "01:02:03:04";
$cstr = $user->ExtraTimeSpan;
Check($cstr, 93784, "timespan (5)", "timespan setter with full string does not work");


Stop();

?>