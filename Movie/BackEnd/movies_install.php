<?php
setMvcEvent("movie_list", "admin", "movie", "list");
setMvcEvent("movie_listupdate", "admin", "movie", "listupdate");
setMvcEvent("movie_view", "admin", "movie", "view");
setMvcEvent("movie_save", "admin", "movie", "save");
setMvcEvent("movie_saveAndContinue", "admin", "movie", "saveAndContinue");
setMvcEvent("movie_add", "admin", "movie", "add");

setMvcEvent("movieCritic_list", "admin", "movieCritic", "list");
setMvcEvent("movieCritic_listupdate", "admin", "movieCritic", "listupdate");
setMvcEvent("movieCritic_view", "admin", "movieCritic", "view");
setMvcEvent("movieCritic_save", "admin", "movieCritic", "save");
setMvcEvent("movieCritic_saveAndContinue", "admin", "movieCritic", "saveAndContinue");
setMvcEvent("movieCritic_add", "admin", "movieCritic", "add");
setMvcEvent("movieCritic_delete", "admin", "movieCritic", "delete");

setMvcEvent("actor_list", "admin", "actor", "list");
setMvcEvent("actor_listupdate", "admin", "actor", "listupdate");
setMvcEvent("actor_view", "admin", "actor", "view");
setMvcEvent("actor_save", "admin", "actor", "save");
setMvcEvent("actor_saveAndContinue", "admin", "actor", "saveAndContinue");
setMvcEvent("actor_add", "admin", "actor", "add");
setMvcEvent("actor_delete", "admin", "actor", "delete");

setMvcEvent("movieactor_view", "admin", "movieactor", "view");
setMvcEvent("movieactor_listupdate", "admin", "movieactor", "listupdate");
setMvcEvent("movieactor_save", "admin", "movieactor", "save");
setMvcEvent("movieactor_saveAndContinue", "admin", "movieactor", "saveAndContinue");
setMvcEvent("movieactor_add", "admin", "movieactor", "add");
setMvcEvent("movieactor_delete", "admin", "movieactor", "delete");

setMvcEvent("moviereview_view", "admin", "moviereview", "view");
setMvcEvent("moviereview_listupdate", "admin", "moviereview", "listupdate");
setMvcEvent("moviereview_save", "admin", "moviereview", "save");
setMvcEvent("moviereview_saveAndContinue", "admin", "moviereview", "saveAndContinue");
setMvcEvent("moviereview_add", "admin", "moviereview", "add");
setMvcEvent("moviereview_delete", "admin", "moviereview", "delete");

// for the front-end
setMvcEvent("movie_main", "movie");
setMvcEvent("movie_review", "movie", "review");
setMvcEvent("movie_genre", "movie", "genre");
setMvcEvent("movie_find", "movie", "find");
setMvcEvent("movie_actor", "movie", "actor");
setMvcEvent("movie_info", "movie", "info");
setMvcEvent("movie_saveReview", "movie", "SaveReview");
setMvcEvent("movie_ReviewSaved", "movie", "ReviewSaved");
setMvcEvent("movie_add", "movie", "Add");
setMvcEvent("movie_saveMovie", "movie", "save");


phpInclude("Movies.php");
?>
