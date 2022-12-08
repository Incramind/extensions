<?php
// all is done, we can now display the form
adminHeader("Movie info");
callTemplate("<div class=\"columns \">");
adminViewSideHead("Movie", "Add a new Movie", "Movie");
adminViewAddTab(true, "General info", "Basic information for a movie");
adminViewAddTab(false, "Actors", "Actors that played in this movie");
adminViewAddTab(false, "Reviews", "list of reviews and scores or this movie");
adminViewSideFooter();
callTemplate("<div class=\"main-col\" id=\"content\">");
adminViewMainColumn("Movie", "[Movie.Name]");

adminViewEditHeader("Movie", $isAdd);
adminViewTabHeader("General info", true);
adminViewFieldInputString("Movie", "name", "Name of the movie");
adminViewFieldInputDate("Movie", "ReleaseDate", "Date of release");
adminViewFieldInputEnum("Genre", "Movie", "Genre", "Genre");
adminViewFieldInputAmount("Movie", "BoxRevenue", "Box office Revenue");
adminViewTabFooter();

adminViewTabHeader("Actors", false);
$ar = array("id", "ActorName", "RoleType");
adminListView("MovieActor", "List of the actors in that movie", $ar, "movieactor/add/".$movie->id, "movieactor/view", "Movie", "[Movie.Id]");
adminViewTabFooter();

adminViewTabHeader("Reviews", false);
$ar = array("Id", "CriticName", "Rating", "Comments");
adminListView("MovieReview", "List of reviews for that movie", $ar, "moviereview/add/".$movie->id, "moviereview/view", "Movie", "[Movie.Id]");
adminViewTabFooter();
adminViewEditFooter("Movie");

callTemplate("</div></div>");
callTemplate("</div></div>");
adminFooter();

?>