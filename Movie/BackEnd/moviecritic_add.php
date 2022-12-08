<?php

// this is called when the used tries to add a new new movie critic in tehe back-end

// first we test if the user is logged in and had the rights to add the data
if (!hasCreateRights("MovieCritic"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to create new movie critic data");
	setPageReturn(ProcessUrl_Error);
	exit;
}

// we make an empty MovieCritic record, so we can fill the screen with defaults

$moviecritic = new MovieCritic();
// you can set additional defaults here

// we set this newly added movieCritic to the templating, so it can be used there
setTemplateScope("MovieCritic", $moviecritic);
$isAdd = true;

// now show the form
phpInclude("moviecritic_show.php");
?>