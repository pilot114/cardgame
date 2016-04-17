<?php

namespace Cardgame\Cards;

class Collection implements Iterator
{
  protected $cards;
  protected $position = 0;

  function __construct(array $cards)
  {
    $this->cards = $cards;
  }

  public function select($selector = null)
  {
    if ($selector) {
      return 'TODO';
    } else {
      return $this->cards;
    }
  }

  public function export()
  {
    $info = [];
    foreach ($this->cards as $card) {
      $info[] = $card->export();
    }
    return $info;
  }


  // Iterator
  function rewind() {
    $this->position = 0;
  }
  function current() {
    return $cards[$this->position];
  }
  function key() {
    return $this->position;
  }
  function next() {
    ++$this->position;
  }
  function valid() {
    return isset($cards[$this->position]);
  }
}
