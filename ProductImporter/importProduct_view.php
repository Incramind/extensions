<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("ImportProduct"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access Imported Product data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we need to locate the ImportProduct given in the url
$importProduct = $website->GetImportProduct($_URL["MVC4"]);
if ($importProduct == NULL)
{
	// if the ImportProduct does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "import with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we set the current import to the templating, so it can be used there
setTemplateScope("ImportProduct", $importProduct);

phpInclude("importProduct_show.php");

?>