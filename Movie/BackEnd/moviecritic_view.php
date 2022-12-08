<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("MovieCritic"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access movie Critic data");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Critic info");
	adminFooter();
	exit;
}

// we need to locate the movie given in the url
$movieCritic = $website->GetCritic($_URL["MVC4"]);
if ($movieCritic == NULL)
{
	// if the movie does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "Movie Critic with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Critic info");
	adminFooter();
	exit;
}

// we set the current movie Critic to the templating, so it can be used there
setTemplateScope("MovieCritic", $movieCritic);
$isAdd = false;

phpInclude("moviecritic_show.php");

?>