<?php

namespace Cardgame;

class Card
{
  private $name;

  private $cost;
  // only for minions
  private $attack;
  private $health;

  private $class;
  private $rarity;
  private $roles = [];
  public $isMinion;
  public $isHidden;

  private $effects = [];
  private $callback;

  function __construct(array $doc)
  {
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
}
