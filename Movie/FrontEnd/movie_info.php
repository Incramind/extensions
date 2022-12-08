<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		[:MetaData, Movie info,info]
		[:Head]
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
						<h2 class="page-title">Information about a Movie</h2>
						<p class="line-top"></p>
						<?php
						$controller = $_URL["CONTROLLER"];
						$movie = $website->GetMovie($controller);
						if ($movie!=null)
						{
							$str = $movie->ReleaseDate->Format("d-m-Y");
							$genre = EnumTypeToString("Genre", $movie->Genre);
							$movieActors = $movie->GetAllActors();
							echo '
							<table class="table table-fixed">
								<tr>
									<td><b>Name</b></td>
									<td>'.$movie->name.'</td>
								</tr>
								<tr>
									<td><b>Release date</b></td>
									<td>'.$str.'</td>
								</tr>
								<tr>
									<td><b>Genre</b></td>
									<td>'.$genre.'</td>
								</tr>
								<tr>
									<td><b>Revenue</b></td>
									<td>'.$movie->boxRevenue.'</td>
								</tr>';
								echo '
									<tr>
										<td rowspan="'. (count($movieActors)+1) .'"><b>Actor/actress</b></td>
									</tr>';
								foreach ($movieActors as $ma)
								{
									$actor = $website->GetActor($ma->actorId);
									if ($actor!=null)
									{
										$role = EnumTypeToString("RoleType", $ma->roleType);
										echo '
											<tr>
												<td>'.$actor->name.' ('.$role.')</td>
											</tr>';
									}
								}
								$reviews = $movie->GetAllReviews();
								echo '
									<tr>
										<td rowspan="'. (count($reviews)+1) .'"><b>Review(s)</b></td>
									</tr>';
								foreach ($reviews as $r)
								{
									$criticName = "";
									$critic = $website->GetCritic($r->criticId);
									if ($critic!=null)
									{
										$criticName = $critic->Name;
										echo '
										<tr>
											<td><b>Review</b></td>
											<td>'.$criticName.' - '.$r->rating.' STARS<br>'.$r->comments.'</td>
										</tr>';
									}
								}							
							echo '
							</table>
							<br/>
							<a href="/movie">back ...</a>
							<a href="/movie/review/'.$movie->id.'">Write review about this movie...</a>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>
</html>
