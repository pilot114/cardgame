<?php

namespace Cardgame\Cards;

class Minions extends Collection
{
  private $targetPosition = 1;
  public function setTargetPosition($position)
  {
    $this->targetPosition = $position;
  }
  public function getTargetPosition()
  {
    return $this->targetPosition;
  }


  public function getByPosition($position)
  {
    var_dump(array_keys($this->cards));
    die();
    $this->cards[$position-1];
  }

  public function setMinion($card, $position)
  {
    $card->setPosition($position);
    $end = array_slice($this->cards, $position-1);
    $merge = array_merge([$card], $end);
    array_splice($this->cards, $position-1, count($this->cards), $merge);
  }

  public function pushMinion($card)
  {
    $this->cards[] = $card;
    $card->setPosition( count($this->cards) );
  }
}
