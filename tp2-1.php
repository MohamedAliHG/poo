<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
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
    public function attack(Pokemon $p): void
    {
      $damage = $this->attackPokemon->getAttackForce();
      $p->setHp(max($p->getHp() - $damage, 0));
    }
    public function whoAmI()
    {
      echo "<img src='{$this->url_image}' alt='Pokemon Image' />";
      echo "<p>Name : {$this->name}</p>";
      echo "<p>HP : {$this->hp}</p>";
      echo "<p>Min Attack Points :  {$this->attackPokemon->getAttackMinimal()}</p>";
      echo "<p>Max Attack Points :  {$this->attackPokemon->getAttackMaximal()}</p>";
      echo "<p>Special Attack :  {$this->attackPokemon->getSpecialAttack()}</p>";
      echo "<p>Probability of Special Attack :  {$this->attackPokemon->getProbabilitySpecialAttack()} %</p>";
    }
  }
  ?>
</body>

</html>