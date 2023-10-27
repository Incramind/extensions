<?php

// first we test if the user is logged in and had the rights to add the data
if (!hasCreateRights("TypesTable"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to create new TypesTable data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we make an empty TypesTable, so we can fill the screen with defaults

$tt = new TypesTable();
// you can set additional defaults here

// we set this newly added movie to the templating, so it can be used there
setTemplateScope("TypesTable", $tt);
$isAdd = true;

// now show the form
phpInclude("TypesTable_show.php");
?>