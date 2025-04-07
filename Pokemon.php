
<?php
require_once 'Loader.php';
class Pokemon
{
    //attributes
    protected $name;
    protected $url_image;
    protected $hp;
    protected $attackPokemon;
    protected $type;

    //constructor
    public function __construct($name, $url_image, int $hp, AttackPokemon $attackPokemon)
    {
        $this->name = $name;
        $this->url_image = $url_image;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
        $this->type = "Normal";
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
    public function getType()
    {
        return $this->type;
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
    public function setType($type)
    {
        $this->type = $type;
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
?>