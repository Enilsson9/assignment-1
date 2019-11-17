<?php

function sim2json($data, $newUsers) {
  foreach ($data as $user => $value) {
    foreach ($newUsers as $newUser => $name) {
      if ($user == $newUser) {
        $newData[$name] = round($value, 2);
      }
    }
  }

  return json_encode($newData, JSON_PRETTY_PRINT);
}


function rec2json($data, $newMovies) {

  $newData = [];
  foreach ($data as $movie => $value) {
    foreach ($newMovies as $newMovie => $name) {
      if ($movie == $newMovie) {
        $newData[$name] = round($value, 2);
      }
    }
  }

  return json_encode($newData, JSON_PRETTY_PRINT);
}
