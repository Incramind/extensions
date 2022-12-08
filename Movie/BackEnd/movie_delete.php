<?php

// first we test if the user is logged in and had the rights to delete the data
if (!hasDeleteRights("Movie"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to delete a Movie");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie info");
	adminFooter();
	exit;
}

// we need to locate the actor given in the url
$movie = $website->GetMovie($_URL["MVC4"]);
if ($movie == NULL)
{
	// if the movie does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "Movie with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie info");
	adminFooter();
	exit;
}

$ret = $website->deleteMovie($movie);

if ($ret)
{
	notification(NotificationType_Notify, "Movie has been deleted");
}
else
{
	notification(NotificationType_Warning, "Movie has NOT been deleted.");
}

redirect("Admin", "Actor/list");

?>