<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("TypesTable"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access TypesTable data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we need to locate the TypesTable record given in the url
$tt = $website->GetTypesSample($_URL["MVC4"]);
if ($tt == NULL)
{
	// if the TypesTable record does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "TypesTable with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we set the current movie to the templating, so it can be used there
setTemplateScope("TypesTable", $tt);
$isAdd = false;

phpInclude("TypesTable_show.php");

?>