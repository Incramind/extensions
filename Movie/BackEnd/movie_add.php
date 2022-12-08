<?php

// this is called when the used tries to add a new new movie critic in tehe back-end

// first we test if the user is logged in and had the rights to add the data
if (!hasCreateRights("Movie"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to create new movie data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we make an empty Movie, so we can fill the screen with defaults

$movie = new Movie();
// you can set additional defaults here

// we set this newly added movie to the templating, so it can be used there
setTemplateScope("Movie", $movie);
$isAdd = true;

// now show the form
phpInclude("movie_show.php");
?>