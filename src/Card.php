<?php

namespace Cardgame;

class Card
{
  private $id;
  private $name;

  private $cost = []; // [base, modificator]
  // only for minions
  private $attack = []; // [base, modificator]
  private $health = []; // [base, modificator]

  private $class;
  private $rarity;
  private $roles = [];
  public $isMinion;
  public $isHidden;

  private $effects = [];
  private $callback;

  // setted if card in Hand or Minion Collection
  private $position;

  function __construct(array $doc)
  {
    $this->id = $doc['id'];
    $this->name = $doc['nm'];
    $this->cost = $doc['cs'];
    $this->attack = isset($doc['at']) ? $doc['at']:null;
    $this->health = isset($doc['hp']) ? $doc['hp']:null;
    $this->class = isset($doc['cl']) ? $doc['cl']:null;
    $this->rarity = $doc['rr'];
    $this->roles = isset($doc['rs']) ? $doc['rs']:null;
    $this->isMinion = $doc['im'];
    $this->isHidden = $doc['ih'];
    $this->effects = isset($doc['ef']) ? $doc['ef']:null;
    $this->callback = isset($doc['cb']) ? $doc['cb']:null;
  }

  public function export()
  {
    return [
      'nm' => $this->name,
      'cs' => $this->cost,
      'at' => $this->attack,
      'hp' => $this->health,
    ];
  }

  public function play($game, $target)
  {
    $cb = $this->callback;
    return $cb($game, $this, $target);
  }

  public function modAttack($val)
  {
    $this->attack[1] += $val;
  }
  public function modHealth($val)
  {
    $this->health[1] += $val;
  }

  public function getPosition()
  {
    return $this->position;
  }
  public function setPosition($position)
  {
    $this->position = $position;
  }

  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }

  public function getHP()
  {
    return $this->health[0] + $this->health[1];
  }
  public function getAttack()
  {
    return $this->attack[0] + $this->attack[1];
  }

  public function damage($point)
  {
    if ($this->health[1] > 0) {
      $this->health[1] -= $point;
      if ($this->health[1] < 0) {
        $this->health[0] += $this->health[1];
      }
    } else {
      $this->health[0] -= $point;
    }
  }

  public function kill()
  {
    $this->health[0] = 0;
    $this->health[1] = 0;
  }
}
