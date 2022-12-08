<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		[:MetaData, Movie,review]
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
							<h2 class="page-title">Write your own movie review</h2>
							<p class="line-top"></p>
							<h3>Write your review a movie</h3>
							<div class="row">
								<div class="col">
									<form method="post" action="/movie/saveReview">
										<div class="form-group">
										  	<label for="Movie"> Name of movie:</label>
										  	<select id="Movie" name="Movie" class="custom-select rounded-0">
										  		<?php
										  		$movies = $website->GetAllMovies();
										  		foreach($movies as $m)
										  		{
											  		echo '<option value="'.$m->id.'">'.$m->Name.'</option>';
										  		}
										  		?>
										  	</select>
										  	<a href="/movie/add">Add a movie</a>
										</div>
										<div class="form-group">
										  	<label for="rating">Rating:</label>
										  	<select id="rating" name="rating" class="custom-select rounded-0">
											 	<option value="0"></option>
											 	<option value="1">1 Star</option>
											 	<option value="2">2 Stars</option>
											 	<option value="3">3 Stars</option>
											 	<option value="4">4 Stars</option>
											 	<option value="5">5 Stars</option>
										  	</select>
										</div>
										<div class="form-group">
										  	<label for="review"> Review:</label>
										  	<textarea type="text" id="review" name="review" class="form-control" placeholder="Enter your review here...." rows="3"></textarea>
										</div>
									  	<button type="submit" class="btn btn-primary rounded-0">Save</button>
									  	<button type="cancel" class="btn btn-secondary rounded-0">Cancel</button>
									  	<a href="/movie" class="btn btn-link"><i class="fas fa-arrow-left"></i> back to main page ...</a>
									</form>
								</div>
								<div class="col"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>
</html>
