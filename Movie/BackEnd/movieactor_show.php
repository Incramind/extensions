<?php
// all is done, we can now display the form
adminHeader("Movie Actor info");
callTemplate("<div class=\"columns \">");
adminViewSideHead("TypesTable", "Add a new Movie Actor record", "Movie Actor");
adminViewAddTab(true, "General info", "Basic information");
adminViewSideFooter();
callTemplate("<div class=\"main-col\" id=\"content\">");
adminViewMainColumn("MovieActor", "[MovieActor.ActorName]");

adminViewEditHeader("MovieActor", $isAdd);
adminViewTabHeader("General info", true);
$allactors = $website->GetAllActors();
$arr[0] = "";
foreach ($allactors as $h)
{
	$arr[$h->id] = $h->name;
}
adminViewFieldInputReference($arr, "MovieActor", "ActorId", "Actor");
adminViewFieldInputEnum("RoleType", "MovieActor", "RoleType", "Role type");
adminViewFieldHidden("movie_id", $parentMovie->id);
adminViewTabFooter();
adminViewEditFooter("MovieActor");

callTemplate("</div></div>");
callTemplate("</div></div>");
adminFooter();
?>

