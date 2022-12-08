<?php
removeMvcEvent("movie_list");
removeMvcEvent("movie_listupdate");
removeMvcEvent("movie_view");
removeMvcEvent("movie_save");
removeMvcEvent("movie_saveAndContinue");
removeMvcEvent("movie_add");

removeMvcEvent("movieCritic_list");
removeMvcEvent("movieCritic_listupdate");
removeMvcEvent("movieCritic_view");
removeMvcEvent("movieCritic_save");
removeMvcEvent("movieCritic_saveAndContinue");
removeMvcEvent("movieCritic_add");
removeMvcEvent("movieCritic_delete");

removeMvcEvent("actor_list");
removeMvcEvent("actor_listupdate");
removeMvcEvent("actor_view");
removeMvcEvent("actor_save");
removeMvcEvent("actor_saveAndContinue");
removeMvcEvent("actor_add");
removeMvcEvent("actor_delete");

removeMvcEvent("movieactor_view");
removeMvcEvent("movieactor_listupdate");
removeMvcEvent("movieactor_save");
removeMvcEvent("movieactor_saveAndContinue");
removeMvcEvent("movieactor_add");
removeMvcEvent("movieactor_delete");

removeMvcEvent("moviereview_view");
removeMvcEvent("moviereview_listupdate");
removeMvcEvent("moviereview_save");
removeMvcEvent("moviereview_saveAndContinue");
removeMvcEvent("moviereview_add");
removeMvcEvent("moviereview_delete");

// for the front-end
removeMvcEvent("movie_main");
removeMvcEvent("movie_review");
removeMvcEvent("movie_genre");
removeMvcEvent("movie_find");
removeMvcEvent("movie_actor");
removeMvcEvent("movie_info");
removeMvcEvent("movie_saveReview");
removeMvcEvent("movie_ReviewSaved");
removeMvcEvent("movie_add");
removeMvcEvent("movie_saveMovie");

removeCustomEnum("Genre");
removeCustomEnum("RoleType");

customTableDelete("Movie");
customTableDelete("Actor");
customTableDelete("MovieActor");
customTableDelete("MovieReview");
customTableDelete("MovieCritic");
	
//deleteCustomReplacer("MovieReview.CriticName.php");
//deleteCustomReplacer("MovieActor.ActorName.php");


?>
