<?php

namespace Cardgame\Cards;


class Hand extends Collection
{

  function __construct()
  {
  }

  public function pushCard(array $cards)
  {
      foreach ($cards as $card) {
        $this->cards[] = $card;
      }
  }
}
