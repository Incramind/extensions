<?php

// first we test if the user is logged in and had the rights to view the data
if (!hasReadRights("Movie"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to access movie data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we need to locate the movie given in the url
$movie = $website->GetMovie($_URL["MVC4"]);
if ($movie == NULL)
{
	// if the movie does not exist, maybe because URL is not clicked but entered manually, we stop
	notification(NotificationType_Violation, "movie with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we set the current movie to the templating, so it can be used there
setTemplateScope("Movie", $movie);

phpInclude("movie_show.php");

?>