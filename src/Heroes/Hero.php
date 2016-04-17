<?php

namespace Cardgame\Heroes;

class Hero
{
  protected $health;
  protected $armor;
  protected $attack;

  protected $spellDamage;

  function __construct()
  {
    $this->health = 30;
    $this->armor = 0;
    $this->attack = 0;
    $this->spellDamage = 0;
  }

  function isPowerRequireTarget()
  {
    return true;
  }

  public function power($target = null)
  {
    return 'HERO power';
  }

  public function damage($point)
  {
    if ($this->armor > 0) {
      $this->armor -= $point;
      if ($this->armor < 0) {
        $this->health += $this->armor;
      }
    } else {
      $this->health -= $point;
    }
  }

  public function getStats()
  {
    return get_class($this) . ' HP: ' . $this->health . ' ARMOR: ' . $this->armor . ' ATTACK: ' . $this->attack;
  }

  public function modSpellDamage($point)
  {
    $this->spellDamage += $point;
  }
}
