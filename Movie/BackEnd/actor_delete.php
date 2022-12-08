<?php

// first we test if the user is logged in and had the rights to delete the data
if (!hasDeleteRights("Actor"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to delete Actor data");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Actor info");
	adminFooter();
	exit;
}

// we need to locate the actor given in the url
$actor = $website->GetActor($_URL["MVC4"]);
if ($actor == NULL)
{
	// if the actor does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "Actor with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Actor info");
	adminFooter();
	exit;
}

$ret = $website->deleteActor($actor);

if ($ret)
{
	notification(NotificationType_Notify, "Actor has been deleted");
}
else
{
	notification(NotificationType_Warning, "Actor has NOT been deleted.");
}

redirect("Admin", "Actor/list");

?>