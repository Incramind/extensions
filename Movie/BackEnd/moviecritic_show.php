<?php
// all is done, we can now display the form
adminHeader("Movie Critic info");
callTemplate("<div class=\"columns \">");
adminViewSideHead("TypesTable", "Add a new Movie Critic record", "Movie Critic");
adminViewAddTab(true, "General info", "Basic information");
adminViewSideFooter();
callTemplate("<div class=\"main-col\" id=\"content\">");
adminViewMainColumn("MovieCritic", "[MovieCritic.Name]");

adminViewEditHeader("MovieCritic", $isAdd);
adminViewTabHeader("General info", true);
adminViewFieldInputString("MovieCritic", "Name", "Name");
adminViewFieldInputString("MovieCritic", "Location", "Location");
adminViewFieldInputString("MovieCritic", "Description", "Description");
adminViewTabFooter();
adminViewEditFooter("MovieCritic");

callTemplate("</div></div>");
callTemplate("</div></div>");
adminFooter();
?>

