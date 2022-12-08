<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		[:MetaData, Movie Add,add]
		[:head]
	</head>
	<body class="Movie.Genre">
		[:HeaderBlock]
		<div class="two-columns-left container">
			[:Notification]
			<div class="main-content">
				<div class="left-column col-md-4 col-lg-3">
					[:leftColumn]			
				</div>
				<div class="main-content col-md-8 col-lg-9">
					<h1>Add a movie</h1>
					<div>
						<h2>Enter the information about this movie</h2> 
						<form method="post" action="/movie/save">
					  		<label> Name of movie:</label>
					  		<input type="text" id="name" name="name" value=""><br/>
					  		<label> Release date:</label>
					  		<input type="text" id="release" name="release" value=""><br/>
					  		<label> Box revenue:</label>
					  		<input type="text" id="revenue" name="revenue" value=""><br/>
							<label>Genre:</label>
							<select id="genre" name="genre">
								<?php
								$values = enumManGetValues("Genre");
								foreach ($values as $v)
									echo '<option value="'.$v.'">'.$v.'</option><br/>';
								?>		
							</select><br/>
					  		<label>Actors / Actresses	</label><br/>
					  		<?php
					  		for ($r = 0; $r <= 10; $r++){
						  		echo '<label>'.$r.'</label><input type="text" id="actor'.$r.'" name="actor'.$r.'" value="">';
						  		echo '<select id="roletype'.$r.'" name="roletype'.$r.'">';
								$values = enumManGetValues("RoleType");
								foreach ($values as $v){
									echo '<option value="'.$v.'">'.$v.'</option>';
						  			echo '</select><br/>';
					  			}
					  		}
					  		?>
					  		<button type="submit">Save</button>
					  		<button type="cancel">Cancel</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>
</html>
