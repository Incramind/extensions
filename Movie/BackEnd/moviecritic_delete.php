<?php

// first we test if the user is logged in and had the rights to delete the data
if (!hasDeleteRights("MovieCritic"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to delete movie Critic data");
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

$ret = $website->deleteCritic($movieCritic);

if ($ret)
{
	notification(NotificationType_Notify, "Movie Critic has been deleted");
}
else
{
	notification(NotificationType_Warning, "Movie Critic has NOT been deleted.");
}

redirect("Admin", "MovieCritic/list");

?>