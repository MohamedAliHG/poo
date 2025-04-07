<?php
require_once 'Loader.php';
class WaterPokemon extends Pokemon
{
    //constructor
    public function __construct($name, $url_image, int $hp, AttackPokemon $attackPokemon)
    {
        parent::__construct($name, $url_image, $hp, $attackPokemon);
        $this->type = "WaterPokemon";
    }

    public function attack(Pokemon $p): int
    {
        $damage = $this->attackPokemon->getAttackForce();
        if ($p->getType() == "PlantPokemon" || $p->getType() == "WaterPokemon") {
            $damage = $damage * 0.5;
        } elseif ($p->getType() == "FirePokemon") {
            $damage = $damage * 2;
        }
        $p->setHp(max($p->getHp() - $damage, 0));
        return $damage;
    }
}
