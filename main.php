<?php

//user a, user b
function euclidean($a, $b) {
  //Init variables
  $sim = 0;
  //Counter for number of matching products
  $n = 0;
  //Iterate over all rating combinations

  foreach ($a as $movieA => $ratingA) {
    foreach ($b as $movieB => $ratingB) {
      if ($movieA == $movieB) {
        $sim += pow($ratingA - $ratingB, 2);
        $n += 1;
      }
    }
  }

  if ($n == 0) {
    return 0;
  }

  $inv = 1 / (1 + $sim);

  return round($inv, 2);
  //return $inv;
}

function getSimilarities($id, $ratings) {
  $cRatings = $ratings;
  //remove id
  unset($cRatings[$id]);

  $similarity = [];

  foreach ($cRatings as $user => $rating) {
    $similarity[$user] = euclidean($ratings[$id], $cRatings[$user]);
  }

  return $similarity;
}


function getRecommendations($id, $movies, $ratings) {
  //get non-seen movies
  $mustWatch = array_diff_key($movies, $ratings[$id]);

  //print_r($mustWatch);

  $cRatings = $ratings;
  //remove id
  unset($cRatings[$id]);

  //get sum of Scores
  $sim = getSimilarities($id, $ratings);


  $scores = [];
  foreach ($cRatings as $user => $rating) {
    foreach ($rating as $movie => $score) {
      if (array_key_exists($movie, $mustWatch)) {
        $scores[$user][$movie] = $score * $sim[$user];
      }
    }
  }

  $sum_scores = [];

  foreach ($scores as $user => $rating) {
    foreach ($rating as $movie => $score) {
        if (!isset($sum_scores[$movie])) {
          $sum_scores[$movie] = $score;
        } else {
          $sum_scores[$movie] += $score;
        }
    }
  }

  //get movies users haven't seen

  //add zeros to ratings
  foreach ($cRatings as $user => $rating) {
    foreach ($rating as $movie => $score) {
      $not_seen[$user][$movie] = $score;
      foreach ($movies as $key => $value) {
        if (!isset($not_seen[$user][$key])) {
          $not_seen[$user][$key] = 0;
        }
      }
    }
  }
  //remove rest
  foreach ($not_seen as $user => $rating) {
    foreach ($rating as $movie => $score) {
      if ($score == 0) {
        $not_seen_only[$user][$movie] = $score;
      }
    }
  }

  //get sum of Similarities
  $newRatings = $movies;

  foreach ($newRatings as $key => $value) {
    $newRatings[$key] = $sim;
  }


  foreach ($not_seen_only as $user => $not_seen_movies) {
    foreach ($not_seen_movies as $movie => $values) {
      $not_seen_only_movies[$movie][$user] = 0;
    }
  }

  $newRatings = array_replace_recursive($newRatings, $not_seen_only_movies);

  foreach ($newRatings as $key => $value) {
    $sum_sim[$key] = array_sum($value);
  }

  foreach ($mustWatch as $key => $value) {
    foreach ($sum_sim as $movie => $score) {
      if ($key == $movie) {
        $sum_sim_must[$key] = $score;
      }
    }
  }

  //get final scores
  $final_scores = [];
  foreach ($sum_scores as $movieA => $valueA) {
    foreach ($sum_sim_must as $movieB => $valueB) {
      if ($movieA == $movieB) {
        $final_scores[$movieA] = round($valueA / $valueB, 2);
      }
    }
  }

  return $final_scores;
}
