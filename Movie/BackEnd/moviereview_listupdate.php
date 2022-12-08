<?php
// this block is called in the listupdate url
// the listupdate url is called when the filtering, pagination or sort-order of the list is changes, and the list is rebuild again

AdminListUpdateSubtable("moviereview", "movie", $_URL["MVC4"]);
?>