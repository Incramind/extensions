<?php
adminHeader("List of movies");

$ar = array("Id", "Name", "ReleaseDate", "Genre", "BoxRevenue");
adminListView("Movie", "List of all movies", $ar, "movie/add", "movie/view");

adminFooter();
?>
