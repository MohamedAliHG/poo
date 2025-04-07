<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pokémon Battle Simulator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .pokemon-card {
      max-width: 300px;
    }

    img {
      width: 200px;
      height: 200px;
      object-fit: contain;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>

<body>
  <div class="container py-4">
    <?php
    require_once 'Loader.php'; // Assuming you have a Loader.php file that includes all necessary classes
    // Creating instances of Pokemons to be our fighting characters
    //Let's start with the attacks 
    $attackPikatchu = new AttackPokemon(10, 80, 2, 25);
    $attackBulbasaur = new AttackPokemon(20, 70, 3, 20);
    $attackCharizard = new AttackPokemon(30, 60, 2, 50);
    $attackWartortle = new AttackPokemon(20, 75, 4, 15);
    //Now let's create the pokemons
    $pikatchu = new Pokemon("Pikatchu", "pikatchu.png", 200, $attackPikatchu);
    $bulbasaur = new PlantPokemon("Bulbasaur", "bulbasaur.webp", 200, $attackBulbasaur);
    $charizard = new FirePokemon("Charizard", "charizard.png", 200, $attackCharizard);
    $wartortle = new WaterPokemon("Wartortle", "wartortle.png", 200, $attackWartortle);
    $pokemons = array($pikatchu, $bulbasaur, $charizard, $wartortle);
    //At this point we will get two pokemons chosen by the user and simulate the battle we will do that using a form 
    ?>
    <h1 class="text-center mb-4">Pokemon Battle Simulator</h1>
    <form method="post" class="mb-4 row">
      <label class="col-md-6">
        Choose your first Pokemon:<br>
        <input type="radio" name="pokemon1" value="Pikatchu" class="form-check-input"> Pikatchu<br>
        <input type="radio" name="pokemon1" value="Bulbasaur" class="form-check-input"> Bulbasaur<br>
        <input type="radio" name="pokemon1" value="Charizard" class="form-check-input"> Charizard<br>
        <input type="radio" name="pokemon1" value="Wartortle" class="form-check-input"> Wartortle<br>
      </label>
      <label class="col-md-6">
        Choose your second Pokemon:<br>
        <input type="radio" name="pokemon2" value="Pikatchu" class="form-check-input"> Pikatchu<br>
        <input type="radio" name="pokemon2" value="Bulbasaur" class="form-check-input"> Bulbasaur<br>
        <input type="radio" name="pokemon2" value="Charizard" class="form-check-input"> Charizard<br>
        <input type="radio" name="pokemon2" value="Wartortle" class="form-check-input"> Wartortle<br>
      </label>
      <input type="submit" value="Fight!" class="btn btn-primary mt-3 mx-auto d-block" style="width: 100px;" />
    </form>
    <?php
    //We will now get the values of the selected pokemons
    if (isset($_POST['pokemon1']) && isset($_POST['pokemon2'])) {
      $pokemon1 = $_POST['pokemon1'];
      $pokemon2 = $_POST['pokemon2'];
      //We will now get the instances of the selected pokemons
      $p1 = null;
      $p2 = null;
      foreach ($pokemons as $p) {
        if ($p->getName() == $pokemon1) {
          $p1 = $p;
        }
        if ($p->getName() == $pokemon2) {
          $p2 = $p;
        }
      }
      //Now we will simulate the battle
      if ($p1 === null || $p2 === null || $p1 === $p2) {
        echo '<div class="alert alert-danger text-center">Error: Invalid Pokemon Selection!</div>';
      } else {
        echo '<h2 class="text-center mb-4">The Fight Starts!</h2>';
        echo '<div class="row mb-4">';
        echo '<div class="col-md-6">';
        $p1->whoAmI();
        echo '</div>';
        echo '<div class="col-md-6">';
        $p2->whoAmI();
        echo '</div>';
        echo '</div>';

        $round = 1;
        //We will now simulate the battle;
        while (!$p1->isDead() && !$p2->isDead()) {
          echo '<div class="alert alert-info">';
          echo "<h3>Round $round</h3>";
          echo '<div class="row alert alert-warning" role="alert"" >';
          echo '<div class="col-md-6">';
          $d = $p1->attack($p2);
          echo $d;
          echo '</div>';
          if (!$p2->isDead()) {
            echo '<div class="col-md-6">';
            $d = $p2->attack($p1);
            echo $d;
            echo '</div>';
          }
          echo '</div>';
          echo '<div class="row">';
          echo '<div class="col-md-6">';
          $p1->whoAmI();
          echo '</div>';
          echo '<div class="col-md-6">';
          $p2->whoAmI();
          echo '</div>';
          echo '</div>';
          echo '</div>';
          $round++;
        }


        //We will now display the result of the battle
        echo '<div class="alert alert-success text-center">';
        if ($p1->isDead()) {
          echo "<h1>{$p2->getName()} is our winner !</h1>";
          echo '<img src="images_tp_web/' . htmlspecialchars($p2->getUrlImage()) . '" class="card-img-top" alt="Pokemon Image">';
        } else {
          echo "<h1>{$p1->getName()} is our winner !</h1>";
          echo '<img src="images_tp_web/' . htmlspecialchars($p1->getUrlImage()) . '" class="card-img-top" alt="Pokemon Image">';
        }

        echo '</div>';
      }
    } else {
      echo '<div class="alert alert-warning text-center"><h1>Please select two pokemons to fight</h1></div>';
    }
    ?>
  </div>
</body>

</html>