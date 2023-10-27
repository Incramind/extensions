<?php
adminHeader("List of TypesTable records");

$ar = array("id", "extraBool", "extraLong", "extraDate", "extraString", "extraTime", "extraColor", "extraTimeSpan");
adminListView("TypesTable", "List of all TypesTables", $ar, "TypesTable/add", "TypesTable/view");

adminFooter();
?>
