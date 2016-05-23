<!-- StarRating widget -->
<script src="/js/starrating.js"></script>

<!-- app's own JavaScript -->
<script src="/js/add.js"></script>

<?php 
    if (!empty($errors1))
    {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$errors1</div>";
    }
    if (!empty($warnings))
    {
        echo "<div class=\"alert alert-success\" role=\"alert\">$warnings</div>";
    }
?>

<form class="form-inline" method="POST" action="add.php">

    <div class="input-group col-md-6">
      <span class="input-group-addon glyphicon glyphicon-film" id="sizing-addon1"></span>
      <input type="text" class="form-control" placeholder="Choose a movie you've watched from list" aria-describedby="sizing-addon1" id="movie" name="movie" value="">
      <input type="hidden" name="imdb-id" id="imdb-id" value="">
      
      <input type="hidden" name="is-new" id="is-new" value="1">
      <input type="hidden" name="released" id="released" value="">
      <input type="hidden" name="rating-imdb" id="rating-imdb" value="">
      <input type="hidden" name="poster" id="poster" value="">
      <input type="hidden" name="plot" id="plot" value="">
      <input type="hidden" name="genre" id="genre" value="">
      <input type="hidden" name="runtime" id="runtime" value="">
    </div>
    
    <div class="input-group">
      <span class="input-group-addon glyphicon glyphicon-calendar" id="sizing-addon2"></span>
      <input type="date" class="form-control" aria-describedby="sizing-addon2" id="date" name="date">
    </div>
    
    <div id="rating-container" class=""></div>
    <input type="hidden" name="rating" id="rating" value=0>
    
    <button type="submit" class="btn btn-default" id="addbutton"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>

</form>

<div class="description bg-info col-md-8">
    <img class="img-rounded poster_img" src="">
    <h3>No movie has been selected</h3>
    
    <span class="imdbRatingPlugin"><a href=""></a></span>

    <p class="movie_info"></p>
    <p class="movie_description"></p>
</div>