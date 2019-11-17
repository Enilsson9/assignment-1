<?php
 include 'data.php';
 include 'main.php';
 include 'json.php';

 $similarities = [];
 $recommendations = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Assignment 1</title>
</head>
<body>
  <h1>Assignment 1</h1>
  <h4>by Edward Nilsson (en222yu)</h4>
  <p> Get similar users and recommended movies based on the Euclidean distance.</p>
  <p> If the user has seen all movies then you won't be able to see any recommendations.</p>
  <p>Data from the large dataset.</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <select class="" name="user">
      <option value="" selected disabled hidden>Choose user</option>
      <?php foreach($newUsers as $key => $value): ?>
      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
      <?php endforeach; ?>
    </select>
    <input type="submit" >
  </form>

  <?php
    if(isset($_POST["user"])) {
      $id = $_POST["user"];

      $sim = getSimilarities($id , $newRatings);
      $mov = getRecommendations($id, $newMovies, $newRatings);

      $similarities = json_decode(sim2json($sim, $newUsers));
      $recommendations = json_decode(rec2json($mov, $newMovies));
    }
  ?>

  <!--Similarities -->
  <?php if (!empty($similarities)) : ?>
    <?php   if(isset($_POST["user"])) :?>
      <h3>Results for <?php echo $newUsers[$id]?></h3>
    <?php endif;?>
    <table>
      <tr>
        <td><strong>User<strong></td>
        <td><strong>Score<strong></td>
      </tr>
      <? foreach ($similarities as $key => $value) : ?>
      <tr>
        <td><? echo $key; ?></td>
        <td><? echo $value; ?></td>
      </tr>
      <? endforeach; ?>
    </table>
  <?php endif; ?>

  <!--Recommendations-->
  <?php if (!empty($recommendations)) : ?>
    <table>
      <tr>
        <td><strong>Movie<strong></td>
        <td><strong>Score<strong></td>
      </tr>
      <? foreach ($recommendations as $key => $value) : ?>
      <tr>
        <td><? echo $key; ?></td>
        <td><? echo $value; ?></td>
      </tr>
      <? endforeach; ?>
    </table>
  <?php endif; ?>
<br>
<br>
</body>
</html>
