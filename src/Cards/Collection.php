<?php

class Collection
{
  private $cards;

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
}
