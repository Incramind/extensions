<?php
// install the hooks
setMvcEvent("typestable_list", "admin", "typestable", "list");
setMvcEvent("typestable_listupdate", "admin", "typestable", "listupdate");
setMvcEvent("typestable_view", "admin", "typestable", "view");
setMvcEvent("typestable_save", "admin", "typestable", "save");
setMvcEvent("typestable_add", "admin", "typestable", "add");
setMvcEvent("typestable_print", "admin", "typestable", "print");

// create an custom enum
addCustomEnum("AnimalType", "What type of Animal it is");
addCustomEnumOption("AnimalType", "Cat", "cat-like");
addCustomEnumOption("AnimalType", "Dog", "dog-like");
addCustomEnumOption("AnimalType", "Elephant", "Elephant-like");
addCustomEnumOption("AnimalType", "Frog", "Frog-like");
addCustomEnumOption("AnimalType", "Dragon", "Dragon-like");
addCustomEnumOption("AnimalType", "Eagle", "Eagle-like");
addCustomEnumOption("AnimalType", "Platypus", "Platypus-like");
addCustomEnumOption("AnimalType", "Spider", "Spider-like");

deleteCustomTable("TypesTable");
// create the table
customTableCreate("TypesTable", "", "test table for different basic types", "TypesSamples");
// add the fields
customTableAddField("TypesTable", "ExtraBool",  REPLACER_TYPE_BOOLEAN, "A additional field for testing bool values");
customTableAddField("TypesTable", "ExtraLong",  REPLACER_TYPE_INTEGER, "A additional field for testing long values");
customTableAddField("TypesTable", "ExtraDouble",  REPLACER_TYPE_NUMERIC, "A additional field for testing double values");
customTableAddField("TypesTable", "ExtraString",  REPLACER_TYPE_STRING, "A additional field for testing string values");
customTableAddField("TypesTable", "ExtraDate",  REPLACER_TYPE_DATE, "A additional field for testing date values");
customTableAddField("TypesTable", "ExtraDateTime",  REPLACER_TYPE_DATETIME, "A additional field for testing date and time values");
customTableAddField("TypesTable", "ExtraTime",  REPLACER_TYPE_TIME, "A additional field for testing time values");
customTableAddField("TypesTable", "ExtraTimeSpan",  REPLACER_TYPE_TIMESPAN, "A additional field for timespan integer values");
customTableAddField("TypesTable", "ExtraColor",  REPLACER_TYPE_COLOR, "A additional field for testing color values");
customTableAddField("TypesTable", "ExtraAmount",  REPLACER_TYPE_AMOUNT, "A additional field for testing amount values");
customTableAddField("TypesTable", "ExtraStoreViewString",  REPLACER_TYPE_STOREVIEW_STING, "A additional field for testing store view string values");
customTableAddField("TypesTable", "ExtraReference",  REPLACER_TYPE_REFERENCE, "A additional field for testing reference values", "Language");
customTableAddField("TypesTable", "ExtraEnum",  REPLACER_TYPE_ENUM, "A additional field for testing enum values", "AnimalType");

// add some data
$tt = new TypesTable();
$tt->ExtraBool = true;
$tt->ExtraLong = 123;
$tt->ExtraDouble = 123.456;
$tt->ExtraString = "This is a string";
$tt->ExtraDate = "25 jan 2021";
$tt->ExtraDateTime = "25 jan 2021 15:28:30";
$tt->ExtraTime = "17:30";
$tt->ExtraTimeSpan = "5:12:30";
$tt->ExtraColor = "Green";
$tt->ExtraAmount = 129.75;
$tt->ExtraStoreViewString = "A test for a storeview";
$tt->ExtraReference = 8;
$tt->ExtraEnum = AnimalType_Eagle;
$website->AddTypesSample($tt);





?>