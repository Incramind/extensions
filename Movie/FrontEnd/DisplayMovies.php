<?php
function DisplayMovies($movies)
{
	if ($movies==null)
	{
		echo "<p>No movies listed</p>";
		return;
	}
	echo '
	<table class="table table-bordered table-sm">
		<thead>
			<tr class="bg-dark text-white">
				<th scope="col" class="fit">#</th>
				<th scope="col">Name</th>
				<th scope="col">Released</th>
				<th scope="col">Genre</th>
				<th scope="col" class="fit">Link</th>
			</tr>
		</thead>
		<tbody>';
			foreach ($movies as $m)
			{
				$n++;
				$str = $m->ReleaseDate->Format("d-m-Y");
				$genre = EnumTypeToString("Genre", $m->Genre);
				echo '
				<tr>
					<th scope="row" class="fit">'.$n.'</th>
					<td>'.$m->Name.'</td>
					<td>'.$str.'</td>
					<td>'.$genre.'</td>
					<td class="fit"><a href="/movie/info/'.$m->Id.'" class="btn btn-link">View info</a></td>
				</tr>';
			}
	echo '
		</tbody>
	</table>';
}
?>