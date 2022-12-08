<h2 class="page-title">Movies</h2>
<p class="line-top"></p>
<div class="row mx-0 mb-4">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Get a list of movies with a Genre</h3>
                <form method="post" action="/movie/genre">
                    <div class="form-group">
                        <label for="genre">Choose a genre</label>
                        <select id="genre" name="genre" class="custom-select rounded-0">
                            <?php
                                $values = enumManGetValues("Genre");
                                foreach ($values as $v)
                                    echo '<option value="'.$v.'">'.$v.'</option><br/>';
                            ?>    
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-0">List</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Find a movie</h3>
                <form method="post" action="/movie/find">
                    <div class="form-group">
                        <label for="name">Name of movie (partly)</label>
                        <input type="text" id="name" name="name" class="form-control rounded-0" placeholder="Name of movie" value="">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-0">List</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Get movies of an actor</h3>
                <form method="post" action="/movie/actor">
                    <div class="form-group">
                        <label for="name">Name of actor/actress (partly)</label>
                        <input type="text" id="name" name="name" class="form-control rounded-0" placeholder="Name of actor/actress" value="">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-0">List</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Write your own review</h3>
                <form method="post" action="/movie/review">
                    <button type="submit" class="btn btn-primary rounded-0">Write a review</button>
                </form>
            </div>
        </div>
    </div>
</div>