<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("MovieReview"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access movie Review data");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Review info");
	adminFooter();
	exit;
}

// we need to locate the movie give in the url
$movieActor = NULL;
$movies = $website->GetAllMovies();
$parentMovie = null;
foreach ($movies as $movie)
{
	$movieReview = $movie->GetReview($_URL["MVC4"]);
	if ($movieReview!=0)
	{
		$parentMovie = $movie;
		break;
	}
}
if ($movieReview == NULL)
{
	// if the movie does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "Movie Actor with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}

// we set the current movie Critic to the templating, so it can be used there
setTemplateScope("MovieReview", $movieReview);
$isAdd = false;

phpInclude("moviereview_show.php");

?>