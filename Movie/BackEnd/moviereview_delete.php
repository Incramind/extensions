<?php

// first we test if the user is logged in and had the rights to delete the data
if (!hasDeleteRights("MovieReview"))
{
	notification(NotificationType_Violation, "user is not logged in or not allowed to delete a movie review record");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie review info");
	adminFooter();
	exit;
}

// we need to locate the movie given in the url
$movieReview = NULL;
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
	notification(NotificationType_Violation, "Movie Review with given ID does not exist");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Actor info");
	adminFooter();
	exit;
}

if ($parentMovie==null)
{
	notification(NotificationType_Violation, "Movie Review has no valid parent");
	setPageReturn(ProcessUrl_Error);
	adminHeader("Movie Review info");
	adminFooter();
	exit;
}
	
$parentId = $parentMovie->Id;
$ret = $parentMovie->deleteReview($movieReview);

if ($ret)
{
	notification(NotificationType_Notify, "Movie Review has been deleted");
}
else
{
	notification(NotificationType_Warning, "Movie Review has NOT been deleted.");
}

redirect("Admin", "Movie/view/".$parentId);

?>