<?php
require_once 'Loader.php';
class PlantPokemon extends Pokemon
{
    //constructor
    public function __construct($name, $url_image, int $hp, AttackPokemon $attackPokemon)
    {
        parent::__construct($name, $url_image, $hp, $attackPokemon);
        $this->type = "PlantPokemon";
    }

    public function attack(Pokemon $p): int
    {
        $damage = $this->attackPokemon->getAttackForce();
        if ($p->getType() == "WaterPokemon" || $p->getType() == "PlantPokemon") {
            $damage = $damage * 0.5;
        } elseif ($p->getType() == "FirePokemon") {
            $damage = $damage * 2;
        }
        $p->setHp(max($p->getHp() - $damage, 0));
        return $damage;
    }
}
