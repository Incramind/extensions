<?php

// this is called when the list function is requsted in the back-end
// it will show a table with all the records
// from this start screen you can add/edit or delete records

// display the admin header and the name of the table
adminHeader("List of Actors");

// give the fields to show in the list, and url's for add and view
$ar = array("id", "name", "Gender", "Image", "Bio");
adminListView("Actor", "List of all actors", $ar, "actor/add", "actor/view");

// display the default footer
adminFooter();
?>
