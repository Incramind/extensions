<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("MovieCritic"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie critic");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("MovieCritic"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie critic");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}


$movieCritic = NULL;
// if there is no ID, we have an ADD and we will create a new record. Otherwise we look it up.
if ($_POST["id"] == 0)
{
	$movieCritic = new MovieCritic();
}
else
{
	$movieCritic = $website->GetCritic($_POST["id"]);
}

// we set all the properties of the record with the values of the post
// note that the post have small letters
$movieCritic->SetName($_POST["name"]);
$movieCritic->SetLocation($_POST["location"]);
$movieCritic->SetDescription($_POST["description"]);

// to check and print the values of  the post, you can use this dump. but comment the last redirect line also
//postDump();

if ($_POST["id"] == 0)
{
	notification(NotificationType_Notify, "MovieCritic added");
	$website->AddCritic($movieCritic);
}
else
{
	notification(NotificationType_Notify, "MovieCritic updated");
}

if (isset($saveAndContinue))
{
	redirect("Admin", "MovieCritic/view/".$movieCritic->GetId());
}
else
{
	redirect("Admin", "MovieCritic/list");
}


?>