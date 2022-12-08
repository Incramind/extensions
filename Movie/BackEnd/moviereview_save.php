<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("MovieReview"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie review record");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("MovieReview"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie review");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}


$movieReview = NULL;
// if there is no ID, we have an ADD and we will create a new record. Otherwise we look it up.
if ($_POST["id"] == 0)
{
	$movieReview = new MovieReview();
}
else
{
	// we need to locate the movie actor
	$movieReview = NULL;
	$movies = $website->GetAllMovies();
	foreach ($movies as $movie)
	{
		$movieReview = $movie->GetActor($_POST["id"]);
		if ($movieReview!=0)
			break;
	}
	if ($movieReview==null)
	{
		notification(NotificationType_Violation, "MovieActor with given ID does not exists");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}

// we set all the properties of the record with the values of the post
// note that the post have small letters
$movieReview->SetCriticId($_POST["critic_id"]);
$movieReview->SetComments($_POST["comments"]);
$movieReview->SetRating($_POST["rating"]);

// to check and print the values of  the post, you can use this dump. but comment the last redirect line also
postDump();

if ($_POST["id"] == 0)
{
	notification(NotificationType_Notify, "MovieReview added");
	
	$movieId = $_POST["movie_id"];
	if ($movieId==0)
	{
		notification(NotificationType_Violation, "Movie_Id is missing in the post");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
	$movie = $website->GetMovie($movieId);
	if ($movie==null)
	{
		notification(NotificationType_Violation, "Movie_Id is not referring to an existing movie");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
	$movie->AddReview($movieReview);
}
else
{
	notification(NotificationType_Notify, "MovieReview updated");
}

/*
if (isset($saveAndContinue))
{
	redirect("Admin", "MovieActor/view/".$movieActor->GetId());
}
else
{
	redirect("Admin", "Movie/view/".$movieId);
}
*/



?>