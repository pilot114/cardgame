<?php

namespace Cardgame\Cards;

use Cardgame\Card;

class Deck extends Collection
{
  function __construct($cardIndexes, $pack)
  {
    foreach ($pack as $card) {
      if ( in_array($card['id'], $cardIndexes) ) {
        $this->cards[] = new Card($card);
      }
    }
  }

  public function pullCardRand($count)
  {
    $pull = [];
    for ($i=0; $i<$count; $i++) {
      shuffle($this->cards);
      $pull[] = array_pop($this->cards);
    }
    return $pull;
  }
}
