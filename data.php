<?php
//csv files
$movies = array_map('str_getcsv', file('movies/movies.csv'));
$users = array_map('str_getcsv', file('movies/users.csv'));
$ratings = array_map('str_getcsv', file('movies/ratings.csv'));

//get users with id - clean
$newUsers = [];

for ($i=1; $i < count($users) ; $i++) {
  $newUsers[$i] = explode(";", $users[$i][0])[1];
}

//get movies with id
$newMovies = [];
for ($i=1; $i < count($movies) ; $i++) {
  $newMovies[$i] = explode(";", $movies[$i][0])[1];
  //if movie is divided
  if (count($movies[$i]) > 1) {
    $newMovies[$i] .= explode(";", $movies[$i][1])[0];
  }

}

//get ratings UserId;MovieId;Rating
$newRatings = [];

for ($i=1; $i < count($ratings); $i++) {
  $currUser = explode(";", $ratings[$i][0])[0];
  $currMovie = explode(";", $ratings[$i][0])[1];
  $currRating = explode(";", $ratings[$i][0])[2];

  $newRatings[$currUser][$currMovie] = $currRating;
}
