<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		[:MetaData, Movie,Genre]
		[:head]
	</head>
	<body class="Movie.Genre">
		[:HeaderBlock]
		<div class="main-content-layout">
			<div class="container-full two-columns-left">
				<div class="row">
					<div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 left-column">
						[:LeftColumnType]		
					</div>
					<div class="col-12 col-sm-9 col-md-9 col-lg-9 col-xl-9 main-content">
						<h2 class="page-title">List of movie for selected Genre</h2>
						<p class="line-top"></p>
						<?php 
							$genre = $_POST["genre"];
							$movies = $website->GetFilteredMovies("Genre", $genre);
							phpInclude("DisplayMovies.php");
							DisplayMovies($movies);
						?>
						<a href="/movie" class="btn btn-link"><i class="fas fa-arrow-left"></i> back to main page ...</a>
					</div>
				</div>
			</div>
		</div>		
		[:FooterBlock]
	</body>
</html>
