
<?php
require_once 'Loader.php';
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
?>