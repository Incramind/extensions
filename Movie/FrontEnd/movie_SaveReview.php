<?php
//postDump();

$movieId = $_POST["Movie"];
$rating = $_POST["rating"];
$reviewText = $_POST["review"];

if ($movieId==0 || $movieId=="")
{
	echo "No movie filled in.";
	notification(NotificationType_Warning, "No movie filled in.");
	//redirect("Movie", "WriteReview");
	exit();
}
$movie = $website->GetMovie($movieId);
if ($movie==null)
{
	echo "No valid movie given.";
	notification(NotificationType_Warning, "No valid movie given.");
	//redirect("Movie", "WriteReview");
	exit();
}


$criticName = "Guest";
if ($customer!=null)
{
	$criticName = $customer->FullName;
}


$critic = $website->GetFilteredCritics("name", $criticName);
if ($critic==null)
{
	$critic = new MovieCritic();
	$critic->Name = $criticName;
	$critic->Location = "";
	$critic->Description = "";
	if ($customer!=null)
	{
		$critic->Location = $customer->City;
		$critic->Description = $customer->EMail;
	}
	$website->AddCritic($critic);
}

$review = new MovieReview();
$review->rating = $rating;
$review->comments = $reviewText;
$review->criticId = $critic->Id;
$movie->AddReview($review);


echo "Your review has been saved.";
notification(NotificationType_Notify, "Your review has been saved.");
redirect("Movie", "ReviewSaved");
?>

