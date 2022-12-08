<?php

// this is called when the list function is requsted in the back-end
// it will show a table with all the records
// from this start screen you can add/edit or delete records

// display the admin header and the name of the table
adminHeader("List of movie Critics");

// give the fields to show in the list, and url's for add and view
$ar = array("id", "name", "Location", "Description");
adminListView("MovieCritic", "List of all movie critics", $ar, "moviecritic/add", "moviecritic/view");

// display the default footer
adminFooter();
?>
