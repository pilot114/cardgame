<?php

namespace Cardgame\Cards;


class Hand extends Collection
{

  public function pushCards(array $cards)
  {
      foreach ($cards as $card) {
        $this->cards[] = $card;
        $card->setPosition( count($this->cards) );
      }
  }

  public function pullCard($position)
  {
    $card = $this->cards[$position];
    unset($this->cards[$position]);
    $this->cards = array_values($this->cards);
    for ($i=0; $i < count($this->cards) ; $i++) {
      $this->cards[$i]->setPosition( $i );
    }
    return $card;
  }
}
