<?php

// this is called when the used tries to add a new new movie critic in the back-end

// first we test if the user is logged in and had the rights to add the data
if (!hasCreateRights("MovieActor"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to create new movie actor record");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we make an empty MovieActor record, so we can fill the screen with defaults

$movieId = $_URL["MVC4"];
$parentMovie = $website->GetMovie($movieId);

$movieactor = new MovieActor();
// you can set additional defaults here

// we set this newly added movieCritic to the templating, so it can be used there
setTemplateScope("MovieActor", $movieactor);
$isAdd = true;

// now show the form
phpInclude("movieactor_show.php");
?>