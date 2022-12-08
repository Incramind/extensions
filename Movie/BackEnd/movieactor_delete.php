<?php

// first we test if the user is logged in and had the rights to delete the data
if (!hasDeleteRights("MovieActor"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to delete a movie actor record");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}

// we need to locate the movie given in the url
$movieActor = NULL;
$movies = $website->GetAllMovies();
$parentMovie = null;
foreach ($movies as $movie)
{
	$movieActor = $movie->GetActor($_URL["MVC4"]);
	if ($movieActor!=0)
	{
		$parentMovie = $movie;
		break;
	}
}

if ($movieActor == NULL)
{
	// if the movie does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "Movie Actor with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}

if ($parentMovie==null)
{
	notification(NotificationType_Violation, "Movie Actor has no valid parent");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}
	
$parentId = $parentMovie->Id;
$ret = $parentMovie->deleteActor($movieActor);

if ($ret)
{
	notification(NotificationType_Notify, "Movie Actor has been deleted");
}
else
{
	notification(NotificationType_Warning, "Movie Actor has NOT been deleted.");
}

redirect("Admin", "Movie/view/".$parentId);

?>