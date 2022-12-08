
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		[:MetaData, Movie list of actor,Actor]
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
						<h2>List of movie for an actor/actress</h2>
						<p class="line-top"></p>
						<?php 
							$name = $_POST["name"];
							$actors = $website->GetFilteredActors("Name", $name);
							phpInclude("DisplayMovies.php");
							// echo '
							// <ul class="list-group">';
							// 	foreach ($actors as $a)
							// 	{
							// 		$actorId = $a->id;
							// 		echo '<li class"list-group-item">Actor: '.$a->name.'</li>';
							// 		$movies = $website->GetAllMovies();
							// 		$moviesFound = [];
							// 		foreach($movies as $m)
							// 		{
							// 			$movie_actors = $m->GetAllActors();
							// 			$index = 0;
							// 			foreach ($movie_actors as $ma)
							// 			{
							// 				if ($ma->ActorId->id == $actorId)
							// 				{
							// 					$moviesFound[$index] = $m;
							// 					$index++;
							// 					break;
							// 				}
							// 			}
							// 		}
							// 		DisplayMovies($moviesFound);
							// 	}
							// echo '
							// </ul>';

							$result = array();
							$movies = $website->GetAllMovies();
							foreach ($movies as $movie) {
								$movie_actors = $movie->GetAllActors();
								$i = 0;
								foreach ($movie_actors as $ma)
								{
									$maId = $ma->ActorId->id;
									foreach ($actors as $actor) {
										if($actor->id == $maId){
											$result[$maId][] = $movie;
											$i++;
										}
									}	
								}
							}
							
							echo '
								<ul class="list-group">';
								foreach ($actors as $a)
								{
									$actorId = $a->id;
									echo '<li class"list-group-item">Actor: '.$a->name.'</li>';
									if(array_key_exists($actorId, $result)){
										foreach ($result as $key => $res) {
											if($key == $actorId){
												DisplayMovies($res);
											}
										}
									}else{
										echo '
											<table class="table table-bordered table-sm">
												<thead>
													<tr class="bg-dark text-white">
														<th scope="col" class="fit">Doesn\'t have movie(s)</th>
													</tr>
												</thead>
											</table>
										';
									}
								}
							echo '
								</ul>';

						?>
						<a href="/movie" class="btn btn-link"><i class="fas fa-arrow-left"></i> back to main page ...</a>
					</div>
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>
</html>
