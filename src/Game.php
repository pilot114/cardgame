<?php

namespace Cardgame;

class Game
{
  private $top = [];
  private $bottom = [];
  private $debug;
  private $currentSide;
  private $isStart = false;

  function __construct($createMsg, $debug)
  {
    list($heroA, $heroB) = array_keys($createMsg);
    $deckA = $createMsg[$heroA];
    $deckB = $createMsg[$heroB];

    $classNameA = __NAMESPACE__ . '\\Heroes\\' . $heroA;
    $classNameB = __NAMESPACE__ . '\\Heroes\\' . $heroB;

    $this->top = [
      'hero' => new $classNameB(),
      'deck' => $deckB
    ];
    $this->bottom = [
      'hero' => new $classNameA(),
      'deck' => $deckA
    ];
    $this->debug = $debug;

    // TODO: select side
    $this->currentSide = $this->top;

    // TODO: eventloop onSend
  }

  private function switchSide()
  {
    $this->currentSide = ($this->currentSide == $this->top) ? $this->bottom : $this->top;
  }

  public function command($command)
  {
    return 'comand result';
  }

  public function state()
  {
    // send to client on create game and on reconnect
    return 'game create';
  }
}
