<?php
// all is done, we can now display the form
adminHeader("TypesTable info");
callTemplate("<div class=\"columns \">");
adminViewSideHead("TypesTable", "Add a new TypesTable record", "[TypesTable.ExtraString]");
adminViewAddTab(true, "General info", "Basic information");
adminViewSideFooter();
callTemplate("<div class=\"main-col\" id=\"content\">");
adminViewMainColumn("TypesTable", "[TypesTable.ExtraString]");

adminViewEditHeader("TypesTable", $isAdd);
adminViewTabHeader("General info", true);
adminViewFieldInputBoolean("TypesTable", "ExtraBool", "Boolean value");
adminViewFieldInputInteger("TypesTable", "ExtraLong", "long value");
adminViewFieldInputNumber("TypesTable", "ExtraDouble", "double value");
adminViewFieldInputString("TypesTable", "ExtraString", "string value");
adminViewFieldInputDate("TypesTable", "ExtraDate", "date value");
adminViewFieldInputDateTime("TypesTable", "ExtraDateTime", "date-time value");
adminViewFieldInputTime("TypesTable", "ExtraTime", "time value");
adminViewFieldInputTimeSpan("TypesTable", "ExtraTimeSpan", "time span value");
adminViewFieldInputColor("TypesTable", "ExtraColor", "color value");
adminViewFieldInputAmount("TypesTable", "ExtraAmount", "amount value");
adminViewFieldInputStoreViewString("TypesTable", "ExtraStoreViewString", "store view string value");
$refValues = array(1 => "Spanish", 2 => "Greek", 4 => "Arabic", 8 => "Bisaya");
adminViewFieldInputReference($refValues, "TypesTable", "ExtraReference", "reference (language) value");
adminViewFieldInputEnum("AnimalType", 0, "TypesTable", "ExtraEnum", "enum (Animal type) value");
adminViewTabFooter();
adminViewEditFooter("TypesTable");

callTemplate("</div></div>");
callTemplate("</div></div>");
adminFooter();
?>