<?php

namespace Cardgame\Cards;

class Collection
{
  protected $cards;

  function __construct(array $cards)
  {
    $this->cards = $cards;
  }

  public function get($index)
  {
    return $this->cards[$index];
  }

  public function set(Card $card)
  {
    $this->cards[] = $card;
  }

  public function select($selector = null)
  {
    if ($selector) {
      return 'TODO';
    } else {
      return $this->cards;
    }
  }

  public function getInfo()
  {
    $info = [];
    foreach ($this->cards as $card) {
      $info[] = $card->getInfo();
    }
    return $info;
  }
}
