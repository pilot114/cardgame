<?php

namespace Cardgame\Cards;

class Minions extends Collection
{
  private $targetPosition = 1;

  function __construct()
  {
  }

  public function setTargetPosition($index)
  {
    $this->targetPosition = $index;
  }

  public function getByIndex($index)
  {

  }
}
