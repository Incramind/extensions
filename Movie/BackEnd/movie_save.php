<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("Movie"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("Movie"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}

$movie = NULL;
if ($_POST["id"] == 0)
{
	$movie = new Movie();
}
else
{
	$movie = $website->GetMovie($_POST["id"]);
}
$movie->SetName($_POST["name"]);
$movie->SetGenre($_POST["genre"]);
$movie->SetBoxRevenue($_POST["box_revenue"]);
$movie->SetReleaseDate($_POST["release_date"]);

if ($_POST["id"] == 0)
{
	notification(NotificationType_Notify, "Movie added");
	$website->AddMovie($movie);
}
else
{
	notification(NotificationType_Notify, "Movie updated");
}

//postDump();
if (isset($saveAndContinue))
{
	redirect("Admin", "movie/view/".$movie->GetId());
}
else
{
	redirect("Admin", "movie/list");
}
?>