<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("MovieActor"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access movie Actor data");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}

// we need to locate the movie give in the url
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

// we set the current movie Critic to the templating, so it can be used there
setTemplateScope("MovieActor", $movieActor);
$isAdd = false;

phpInclude("movieactor_show.php");

?>