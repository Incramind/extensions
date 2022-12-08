<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("Actor"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access Actor data");
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

// we set the current movie Critic to the templating, so it can be used there
setTemplateScope("Actor", $actor);
$isAdd = false;

phpInclude("actor_show.php");

?>