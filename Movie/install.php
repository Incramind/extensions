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


CreateTableDefinitions();
// clear it if needed
//$website->ClearActors();
//$website->ClearMovies();
//$website->ClearCritics();

CreateTestData($website);
// some test code, disabled
//ListAllData($website);
//displayActors($website, "chris");
//displayActors($website, "a");



function CreateTableDefinitions()
{
	addCustomEnum("Genre", "The Genre of a movie");
	addCustomEnumOption("Genre", "Fantasy", "Fantasy movie");
	addCustomEnumOption("Genre", "Action", "Action movies");
	addCustomEnumOption("Genre", "Triller", "Thriller movies");
	addCustomEnumOption("Genre", "Drama", "Drama movies");
	addCustomEnumOption("Genre", "Horror", "Horror movies");

	addCustomEnum("RoleType", "the type of the role the actor/actress plays in movies");
	addCustomEnumOption("RoleType", "Lead", "The main role, there can be more leas role in a movie");
	addCustomEnumOption("RoleType", "Support", "An important support role");
	addCustomEnumOption("RoleType", "Character", "A character role, playing a character in depth");

	customTableCreate("Movie", "", "Cinema and TV movies", "movies", "blog");
	customTableAddField("Movie", "Name",  REPLACER_TYPE_STRING, "The name of the movie");
	customTableAddField("Movie", "ReleaseDate",  REPLACER_TYPE_DATE, "The approximate date of release");
	customTableAddField("Movie", "Genre",  REPLACER_TYPE_ENUM, "What kind of movie it is", "Genre");
	customTableAddField("Movie", "BoxRevenue",  REPLACER_TYPE_AMOUNT, "The revenue of the movie");

	customTableCreate("Actor", "", "Actors and Actresses", "Actors", "blog");
	customTableAddField("Actor", "Name",  REPLACER_TYPE_STRING, "The name of the actor/actress");
	customTableAddField("Actor", "Gender",  REPLACER_TYPE_ENUM, "The gender of the actor/actress", "GenderType");
	customTableAddField("Actor", "Image",  REPLACER_TYPE_STRING, "A picture of the actor/actress");
	customTableAddField("Actor", "Bio",  REPLACER_TYPE_STRING, "Free bio information about the actor");

	customTableCreate("MovieActor", "Movie", "Connection table between movies and actors", "Actors", "blog");
	customTableAddField("MovieActor", "ActorId",  REPLACER_TYPE_REFERENCE, "reference to the actor table", "Actor");
	customTableAddField("MovieActor", "RoleType",  REPLACER_TYPE_ENUM, "Main role, or secondary", "RoleType");

	customTableCreate("MovieReview", "Movie", "Reviews for a movie", "Reviews", "blog");
	customTableAddField("MovieReview", "CriticId",  REPLACER_TYPE_REFERENCE, "reference to the person giving reviews", "MovieCritic");
	customTableAddField("MovieReview", "Rating",  REPLACER_TYPE_NUMERIC, "Percentage rating between 0 and 100");
	customTableAddField("MovieReview", "Comments",  REPLACER_TYPE_STRING, "Free text field, with description of the review. multiple lines");

	customTableCreate("MovieCritic", "", "Critics and persons reviewing movies", "Critics", "blog");
	customTableAddField("MovieCritic", "Name",  REPLACER_TYPE_STRING, "Name of the person giving the reviews");
	customTableAddField("MovieCritic", "Location",  REPLACER_TYPE_STRING, "Location of the person giving the reviews");
	customTableAddField("MovieCritic", "Description",  REPLACER_TYPE_STRING, "Some more information and maybe a link of the person giving the reviews");
	
	addCustomReplacer("MovieReview.CriticName.php", "MovieReview", "CriticName", REPLACER_TYPE_STRING, "The name of the critic to use directly in the list");
	addCustomReplacer("MovieActor.ActorName.php", "MovieActor", "ActorName", REPLACER_TYPE_STRING, "The name of the actor in a movie to use directly in the list");
	
}

function CreateTestData($website)
{
	// now we are going to fill it with some test data
	if ($website->CountCritics() == 0)
	{
		$critic = new MovieCritic();
		$critic->Name = "Dennis";
		$critic->Location = "Netherlands";
		$critic->Description = "Just some guy with an opinion";
		$website->AddCritic($critic);

		$critic = new MovieCritic();
		$critic->SetName("Rotten tomatoes");
		$critic->SetLocation("USA");
		$critic->SetDescription("professional movie review site");
		$website->AddCritic($critic);

		$critic = new MovieCritic();
		$critic->SetName("Rose");
		$critic->SetLocation("Philippines");
		$critic->SetDescription("Movie addict");
		$website->AddCritic($critic);
	}
	// create some actors

	if ($website->CountActors() == 0)
	{
		$actor = new Actor();
		$actor->Name = "Angelina Jolie";
		$actor->Gender = Gender_Female;
		$actor->Image = "actors/angelina.jpg";
		$actor->Bio = "Angelina Jolie is an American actress, filmmaker, and humanitarian. The recipient of such accolades as an Academy Award and three Golden Globe Awards, she has been named Hollywood's highest-paid actress multiple times.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Zoe Saldana";
		$actor->Gender = Gender_Female;
		$actor->Image = "actors/zoe.jpg";
		$actor->Bio = "Zoë Yadira Saldaña Nazario is an American actress. Following her performances with the theater group Faces, she was in a 1999 episode of Law & Order. Her film career began a year later with Center Stage portraying a ballet dancer.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Chris Hemsworth";
		$actor->Gender = Gender_Male;
		$actor->Image = "actors/chris.jpg";
		$actor->Bio = "Christopher Hemsworth is an Australian actor. He rose to prominence playing Kim Hyde in the Australian TV series Home and Away before beginning a film career in Hollywood by taking on parts in the science fiction film Star Trek and the thriller A Perfect.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Tom Holland";
		$actor->Gender = Gender_Male;
		$actor->Image = "actors/tom.jpg";
		$actor->Bio = "Thomas Stanley Holland is an English actor. He first gained recognition for his starring role in the disaster film The Impossible, receiving the London Film Critics Circle Award for Young British Performer of the Year.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Gal Gadot";
		$actor->Gender = Gender_Female;
		$actor->Image = "actors/gal.jpg";
		$actor->Bio = "Gal Gadot is an Israeli actress, model, and producer. At age 18, she was crowned Miss Israel 2004. She then served two years in the Israel Defense Forces as a fitness/combat readiness instructor.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Tia Carrere";
		$actor->Gender = Gender_Female;
		$actor->Image = "actors/tia.jpg";
		$actor->Bio = "Althea Rae Duhinio Janairo, known professionally as Tia Carrere, is an American actress, singer, and former model, who obtained her first big break as a regular on the daytime soap opera General Hospital.";
		$website->AddActor($actor);

		$actor = new Actor();
		$actor->Name = "Arnold Schwarzenegger";
		$actor->Gender = Gender_Female;
		$actor->Image = "actors/arnold.jpg";
		$actor->Bio = "Arnold Alois Schwarzenegger is an Austrian-American actor, filmmaker, businessman, author, and former politician and professional bodybuilder. He served as the 38th Governor of California from 2003 to 2011. As of 2020, he is the most recent Republican governor of California.";
		$website->AddActor($actor);
	}

	if ($website->CountMovies() == 0)
	{
		// add a movie
		$movie = new Movie();
		$movie->Name = "True Lies";
		$movie->ReleaseDate = "1 jan 2010";
		$movie->Genre = Genre_Action;
		$movie->BoxRevenue = 120000000;
		$website->AddMovie($movie);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Arnold");
		$movieActor->RoleType = RoleType_Lead;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Carrere");
		$movieActor->RoleType = RoleType_Support;
		$movie->AddActor($movieActor);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "dennis");
		$review->Rating = 95.0;
		$review->Comments = "Like a James Bond movie, but then more spectacular and actually very funny too. Great humor, solid story."; 
		$movie->AddReview($review);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "rotten");
		$review->Rating = 75.0;
		$review->Comments = "Nice movie."; 
		$movie->AddReview($review);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "rose");
		$review->Rating = 85.0;
		$review->Comments = "It's okay."; 
		$movie->AddReview($review);

		// add another movie
		$movie = new Movie();
		$movie->Name = "Wonder Woman";
		$movie->ReleaseDate = "1 jun 2018";
		$movie->Genre = Genre_Fantasy;
		$movie->BoxRevenue = 34*1000*1000;
		$website->AddMovie($movie);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Gal");
		$movieActor->RoleType = RoleType_Lead;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Holland");
		$movieActor->RoleType = RoleType_Support;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Chris");
		$movieActor->RoleType = RoleType_Support;
		$movie->AddActor($movieActor);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "dennis");
		$review->Rating = 80.0;
		$review->Comments = "not too bad, and she looks gorgeous."; 
		$movie->AddReview($review);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "rotten");
		$review->Rating = 85.0;
		$review->Comments = "Nice movie."; 
		$movie->AddReview($review);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "rose");
		$review->Rating = 92.0;
		$review->Comments = "I like it."; 
		$movie->AddReview($review);

		// add another movie
		$movie = new Movie();
		$movie->Name = "Superman";
		$movie->ReleaseDate = "1 dec 2018";
		$movie->Genre = Genre_Fantasy;
		$movie->BoxRevenue = 27.5*1000*1000;
		$website->AddMovie($movie);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Gal");
		$movieActor->RoleType = RoleType_Support;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Holland");
		$movieActor->RoleType = RoleType_Support;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Not existing");  // to test that this will be 0
		$movieActor->ActorId = $website->FindActor("name", "Chris");
		$movieActor->RoleType = RoleType_Lead;
		$movie->AddActor($movieActor);

		$movieActor = new MovieActor();
		$movieActor->ActorId = $website->FindActor("name", "Arnold");
		$movieActor->RoleType = RoleType_Lead;
		$movie->AddActor($movieActor);

		$actor = $website->FindActor("name", "Saldana");
		if ($acctor!=NULL)
		{
			$movieActor = new MovieActor();
			$movieActor->ActorId = $actor->Id;
			$movieActor->RoleType = RoleType_Support;
			$movie->AddActor($movieActor);
		}

		$actor = $website->FindActor("name", "Clark");
		if ($actor!=NULL)
		{
			$movieActor = new MovieActor();
			$movieActor->ActorId = $actor->Id;
			$movieActor->RoleType = RoleType_Support;
			$movie->AddActor($movieActor);
		}


		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "dennis");
		$review->Rating = 60.0;
		$review->Comments = "well...."; 
		$movie->AddReview($review);

		$review = new MovieReview();
		$review->CriticId = $website->FindCritic("name", "rotten");
		$review->Rating = 85.0;
		$review->Comments = "Bla bla bla."; 
		$movie->AddReview($review);
	}
}

/* some test code
function ListAllData($website)
{
	echo "<h2>Listing all data</h2>";
	
	echo "<h3>actors</h3>";
	$actors = $website->GetAllActors();
	echo "<table>";
	foreach ($actors as $a)
	{
		echo "<tr><td>".$a->Name."</td><td>".$a->Gender."</td><td>".$a->Image."</td><td>".$a->Bio."</td></tr>";
	}
	echo "</table>";

	echo "<h3>Critic</h3>";
	$critics = $website->GetAllCritics();
	echo "<table>";
	foreach ($critics as $a)
	{
		echo "<tr><td>".$a->Name."</td><td>".$a->Location."</td><td>".$a->Description."</td></tr>";
	}
	echo "</table>";

	echo "<h3>Movies</h3>";
	$movies = $website->GetAllMovies();
	foreach ($movies as $a)
	{
		echo "<h4>".$a->Name."</h4>";
		$strDate = date_format($a->ReleaseDate,"Y/m/");
		echo "<table><tr><td>Release date:</td><td>".$strDate."</td></tr>";
		echo "<table><tr><td>Genre:</td><td>".$a->Genre."</td></tr>";
		echo "<table><tr><td>Box Revenue:</td><td>".$a->boxRevenue."</td></tr>";
		echo "<table><tr><td>Actors:</td><td>";
		$actors = $a->GetAllActors();
		foreach ($actors as $ma)
		{
			echo "<ul>";
			echo "<li>";
			echo $ma->actorId->Name;
			echo "&nbsp;(";
			echo $ma->roleType;
			echo ")</li>";
			echo "</ul>";
		}
		echo "</td></tr>";
		echo "<table><tr><td>Reviews:</td><td>";
		$reviews = $a->GetAllReviews();
		foreach ($reviews as $re)
		{
			echo $re->criticId->Name;
			echo "&nbsp<b>Rating: ".$re->Rating."%</b><br/>";
			echo $re->comments;
			echo "<br/>";
		}
		echo "</td></tr>";
		echo "</table>";
	}
	
}



function displayActors($website, $contains)
{
	echo "<h2>Displaying all actors with ".$contains."</h2>";
	// we will loop all the actors
	$actors = $website->GetFilteredActors("name", $contains);
	foreach($actors as $actor)
	{
		echo "<h3>".$actor->Name."</h3>";
		// now we are going to display all the movies of a certain actor
		
		displayMovies($website, $actor);
		echo "<br><br>";
	}
}


function displayMovies($website, $actor)
{
	foreach($website->movies as $movie)
	{
		$movieactors = $movie->GetAllActors();
		foreach ($movieactors as $ma)
		{
			if ($ma->ActorId->Id == $actor->Id)
			{
				echo $movie->name;
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo $ma->ActorId->Name;
				switch ($ma->RoleType)
				{
					case RoleType_Lead: echo "&nbsp; (LEAD)"; break;
					case RoleType_Support: echo "&nbsp; (Support)"; break;
					case RoleType_Character: echo "&nbsp; (character role)"; break;
				}
				echo "<br/>";
			}
		}
	}
};
*/

?>



