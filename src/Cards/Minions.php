<?php

namespace Cardgame\Cards;

class Minions extends Collection
{
  private $targetPosition = 0;

  function __construct()
  {
  }

  public function setTargetPosition($index)
  {
    $this->targetPosition = $index;
  }
}
