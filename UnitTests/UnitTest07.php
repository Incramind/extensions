<?php

phpInclude("UnitTest_check.php");

Start("07", "Enum definition");



addCustomEnum("FruitType", "Type of the fruit");
addCustomEnumOption("FruitType", "Apple", "apple fruits", 1);
addCustomEnumOption("FruitType", "Banana", "banana fruits", 2);
addCustomEnumOption("FruitType", "Mango", "mango fruits");
addCustomEnumOption("FruitType", "passion fruit", "passion fruits fruits");
addCustomEnumOption("FruitType", "grapes", "grapes fruits", 2);

$descr = enumManGetDescription("FruitType");
Check($descr, "Type of the fruit", "description", "check if the description is in the manual");

$ar = enumManGetValues("FruitType");
Check(sizeof($ar), 6, "values 1", "number of values");
Check($ar[0], "Unknown", "values 2", "value 0 is not Unknown");
Check($ar[1], "Apple", "values 3", "value 1 is not right");
Check($ar[2], "Banana", "values 4", "value 2 is not right");
Check($ar[3], "Mango", "values 5", "value 3 is not right");
Check($ar[4], "passionfruit", "values 6", "value 4 is not right");
Check($ar[5], "grapes", "values 7", "value 5 is not right");

$descr = enumManGetValueInfo("FruitType", "Apple");
Check($descr, "apple fruits", "description 1", "description of a value is not correct");

$str = enumTypeToString("FruitType", 4);
Check($str, "passionfruit", "to string 1", "conversion int to enum string not correct");
$str = enumTypeToString("FruitType", 5);
Check($str, "grapes", "to string 2", "conversion int to enum string not correct");
$str = enumTypeToString("FruitType", 1);
Check($str, "Apple", "to string 3", "conversion int to enum string not correct");
$str = enumTypeToString("FruitType", 0);
Check($str, "Unknown", "to string 4", "conversion int to enum string not correct");

$nr = stringToEnumType("FruitType", "apple");
Check($nr, 1, "from string 1", "conversion string to int to enum string not correct");
$nr = stringToEnumType("FruitType", "unknown");
Check($nr, 0, "from string 2", "conversion string to int to enum string not correct");
$nr = stringToEnumType("FruitType", "passionfruit");
Check($nr, 4, "from string 3", "conversion string to int to enum string not correct");

Check(FruitType_Apple, 1, "constants 1", "check if the constants are defined");
Check(FruitType_Banana, 2, "constants 2", "check if the constants are defined");
Check(FruitType_Mango, 3, "constants 3", "check if the constants are defined");
Check(FruitType_passionfruit, 4, "constants 4", "check if the constants are defined");
Check(FruitType_grapes, 5, "constants 5", "check if the constants are defined");

removeCustomEnum("FruitType");

// extend an existing enum

addCustomEnumOption("ProductType", "Calculatable", "products that are automatic calculated", 100);
$ar = enumManGetValues("ProductType");
$exist = false;
foreach($ar as $a)
{
	if ($a == "Calculatable")
		$exist = true;
}
Check($exist, true, "extend 1", "check if possible to extend an existing enum");

$ar = incraLogGetLastLoggings(4);
$nrLogsAfter = sizeof($ar);
Check($nrLogs, $nrLogsAfter, "syntax", "some syntax errors where thrown while executing");

$descr = enumManGetValueInfo("ProductType", "Calculatable");
Check($descr, "products that are automatic calculated", "extended 2", "description not correct");

$str = enumTypeToString("ProductType", 1001);
Check($str, "Calculatable", "ex to string 1", "conversion int to enum string not correct, producttype");
$str = enumTypeToString("ProductType", ProductType_Grouped);
Check($str, "Grouped", "ex to string 2", "conversion int to enum string not correct, producttype");

$nr = stringToEnumType("ProductType", "grouped");
Check($nr, ProductType_Grouped, "ex from string 2", "conversion string to int to enum string not correct");
$nr = stringToEnumType("ProductType", "Calculatable");
Check($nr, 1001, "ex from string 2", "conversion string to int to enum string not correct");

Check(ProductType_Calculatable, 1001, "constants 4", "check if the constants are defined");
Check(ProductType_Grouped, 5, "constants 5", "check if the constants are defined");

Stop();


?>