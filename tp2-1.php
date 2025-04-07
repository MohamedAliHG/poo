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
    class AttackPokemon
    {
      //attributes
      private $attackMinimal;
      private $attackMaximal;
      private $specialAttack;
      private $ProbabilitySpecialAttack;
      //constructor
      public function __construct(int $attackMinimal, int $attackMaximal, int $specialAttack, int $ProbabilitySpecialAttack)
      {
        $this->attackMinimal = $attackMinimal;
        $this->attackMaximal = $attackMaximal;
        $this->specialAttack = $specialAttack;
        $this->ProbabilitySpecialAttack = $ProbabilitySpecialAttack;
      }
      //getters
      public function getAttackMaximal()
      {
        return $this->attackMaximal;
      }
      public function getAttackMinimal()
      {
        return $this->attackMinimal;
      }
      public function getSpecialAttack()
      {
        return $this->specialAttack;
      }
      public function getProbabilitySpecialAttack()
      {
        return $this->ProbabilitySpecialAttack;
      }
      //setters(won't really be used in our case)
      public function setAttackMaximal(int $attackMaximal)
      {
        if ($attackMaximal < 0) {
          throw new Exception("Attack cannot be negative");
        }
        if ($attackMaximal < $this->attackMinimal) {
          throw new Exception("Attack maximal cannot be less than attack minimal");
        }
        $this->attackMaximal = $attackMaximal;
      }
      public function setAttackMinimal(int $attackMinimal)
      {
        if ($attackMinimal < 0) {
          throw new Exception("Attack cannot be negative");
        }
        if ($attackMinimal > $this->attackMaximal) {
          throw new Exception("Attack minimal cannot be greater than attack maximal");
        }
        $this->attackMinimal = $attackMinimal;
      }
      public function setSpecialAttack(int $specialAttack)
      {
        if ($specialAttack < 0) {
          throw new Exception("Special attack cannot be negative ");
        }
        $this->specialAttack = $specialAttack;
      }
      public function setProbabilitySpecialAttack(int $ProbabilitySpecialAttack)
      {
        if ($ProbabilitySpecialAttack < 0 || $ProbabilitySpecialAttack > 100) {
          throw new Exception("Probability of special attack must be between 0 and 100");
        }
        $this->ProbabilitySpecialAttack = $ProbabilitySpecialAttack;
      }
      //methods
      //We will add a method to determine the attack force
      //AS shown in the example in the TP task this value will be randomly calculated each round 
      //We will first see compute randomly a value between the attack minimal and maximal values
      //Then we will see if the special attack is activated or not to finally return the result
      public function getAttackForce(): int
      {
        $attackPoints = rand($this->attackMinimal, $this->attackMaximal);
        $prob = rand(0, 100);
        if ($prob <= $this->ProbabilitySpecialAttack) {
          $attackPoints *= $this->specialAttack;
        }
        return $attackPoints;
      }
    }
    class Pokemon
    {
      //attributes
      private $name;
      private $url_image;
      private $hp;
      private $attackPokemon;

      //constructor
      public function __construct($name, $url_image, int $hp, AttackPokemon $attackPokemon)
      {
        $this->name = $name;
        $this->url_image = $url_image;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
      }
      //getters
      public function getName()
      {
        return $this->name;
      }
      public function getUrlImage()
      {
        return $this->url_image;
      }
      public function getHp()
      {
        return $this->hp;
      }
      public function getAttackPokemon()
      {
        return $this->attackPokemon;
      }
      //setters 
      public function setName($name)
      {
        $this->name = $name;
      }
      public function setUrlImage($url_image)
      {
        $this->url_image = $url_image;
      }
      public function setHp(int $hp)
      {
        if ($hp < 0) {
          throw new Exception("HP cannot be negative");
        }
        $this->hp = $hp;
      }
      public function setAttackPokemon(AttackPokemon $attackPokemon)
      {
        $this->attackPokemon = $attackPokemon;
      }
      //methods
      public function isDead(): bool
      {
        return ($this->hp <= 0);
      }
      public function attack(Pokemon $p): int
      {
        $damage = $this->attackPokemon->getAttackForce();
        $p->setHp(max($p->getHp() - $damage, 0));
        return $damage;
      }
      public function whoAmI()
      {
        echo '<div class="card pokemon-card">';
        echo '<img src="images_tp_web/' . htmlspecialchars($this->url_image) . '" class="card-img-top" alt="Pokemon Image">';
        echo '<div class="card-body">';
        echo "<h5 class=\"card-title\">{$this->name}</h5>";
        echo "<p class=\"card-text\">HP: {$this->hp}</p>";
        echo "<p class=\"card-text\">Min Attack: {$this->attackPokemon->getAttackMinimal()}</p>";
        echo "<p class=\"card-text\">Max Attack: {$this->attackPokemon->getAttackMaximal()}</p>";
        echo "<p class=\"card-text\">Special Attack: {$this->attackPokemon->getSpecialAttack()}</p>";
        echo "<p class=\"card-text\">Special Attack Chance: {$this->attackPokemon->getProbabilitySpecialAttack()}%</p>";
        echo '</div></div>';
      }
    }
    // Creating instances of Pokemons to be our fighting characters
    //Let's start with the attacks 
    $attackPikatchu = new AttackPokemon(10, 80, 2, 25);
    $attackBulbasaur = new AttackPokemon(20, 70, 3, 20);
    $attackCharizard = new AttackPokemon(30, 60, 2, 50);
    $attackWartortle = new AttackPokemon(20, 75, 4, 15);
    //Now let's create the pokemons
    $pikatchu = new Pokemon("Pikatchu", "pikatchu.png", 200, $attackPikatchu);
    $bulbasaur = new Pokemon("Bulbasaur", "bulbasaur.webp", 200, $attackBulbasaur);
    $charizard = new Pokemon("Charizard", "charizard.png", 200, $attackCharizard);
    $wartortle = new Pokemon("Wartortle", "wartortle.png", 200, $attackWartortle);
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