<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("MovieActor"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie actor record");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("MovieActor"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a movie actor");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}


$movieActor = NULL;
// if there is no ID, we have an ADD and we will create a new record. Otherwise we look it up.
if ($_POST["id"] == 0)
{
	$movieActor = new MovieActor();
}
else
{
	// we need to locate the movie actor
	$movieActor = NULL;
	$movies = $website->GetAllMovies();
	foreach ($movies as $movie)
	{
		$movieActor = $movie->GetActor($_POST["id"]);
		if ($movieActor!=0)
			break;
	}
	if ($movieActor==null)
	{
		notification(NotificationType_Violation, "MovieActor with given ID does not exists");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}

// we set all the properties of the record with the values of the post
// note that the post have small letters
$movieActor->SetActorId($_POST["actor_id"]);
$movieActor->SetRoleType($_POST["role_type"]);

// to check and print the values of  the post, you can use this dump. but comment the last redirect line also
//postDump();

if ($_POST["id"] == 0)
{
	notification(NotificationType_Notify, "MovieActor added");
	
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
	$movie->AddActor($movieActor);
}
else
{
	notification(NotificationType_Notify, "MovieActor updated");
}


if (isset($saveAndContinue))
{
	redirect("Admin", "MovieActor/view/".$movieActor->GetId());
}
else
{
	redirect("Admin", "Movie/view/".$movieId);
}




?>