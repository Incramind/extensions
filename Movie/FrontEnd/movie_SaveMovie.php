<?php
//postDump();

$name = $_POST["name"];
$revenue = $_POST["revenue"];
$release = $_POST["release"];
$genre = $_POST["genre"];



$movie = new Movie();
$movie->name = $name;
$movie->releaseDate = $release;
$movie->boxRevenue = $revenue;
$movie->genre = $genre;

for ($r = 0; $r <= 10; $r++)
{
	$actorName = $_POST["actor$r"];
	if ($actorName=="")
		continue;
	$actor = $website->FindActor("name", $actorName);
	if ($actor==0)
	{
		$actor = new Actor();
		$actor->Name = $actorName;
		$website->AddActor($actor);
	}
	$ma = new MovieActor();
	$ma->ActorId = $actor->Id;
	$ma->RoleType = $_POST["roletype$r"];
	$movie->AddActor($ma);
}
$website->AddMovie($movie);


echo "Your review has been saved.";
notification(NotificationType_Notify, "Your movie has been saved.");
redirect("Movie", "Review");
?>

