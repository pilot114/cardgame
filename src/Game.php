<?php

namespace Cardgame;

use Cardgame\Cards\Deck;
use Cardgame\Cards\Hand;
use Cardgame\Cards\Minions;
use Cardgame\Cards\Gone;

use Cardgame\Exceptions\ClientException;

class Game
{
  private $top = [];
  private $bottom = [];
  private $debug;
  private $fs; // friendlySide
  private $es; // enemySide
  private $isStart = false;
  private $result = [];

  function __construct($createMsg, $debug)
  {
    list($heroA, $heroB) = array_keys($createMsg);
    $deckA = $createMsg[$heroA];
    $deckB = $createMsg[$heroB];

    $classNameA = __NAMESPACE__ . '\\Heroes\\' . $heroA;
    $classNameB = __NAMESPACE__ . '\\Heroes\\' . $heroB;

    // TODO: in config
    $pack = require('../decks/Demo.php');

    $this->top = [
      'hero' => new $classNameB(),
      'deck' => new Deck($deckB, $pack),
      'hand' => new Hand(),
      'minions' => new Minions(),
      'gone' => new Gone(),
    ];
    $this->bottom = [
      'hero' => new $classNameA(),
      'deck' => new Deck($deckA, $pack),
      'hand' => new Hand(),
      'minions' => new Minions(),
      'gone' => new Gone(),
    ];
    $this->debug = $debug;

    // TODO: random select side
    $this->fs = $this->top;
    $this->es = $this->bottom;
  }

  private function switchSide()
  {
    list($this->fs, $this->es) = [$this->es, $this->fs];
  }

  public function command($command)
  {
    // power
    if( isset($command['power']) ) {
      if ($this->fs['hero']->isPowerRequireTarget()) {
        $target = $this->getTarget($command);
        $this->result[] = $this->fs['hero']->power($target);
      } else {
        $this->result[] = $this->fs['hero']->power();
      }
    }
    // hero attack
    // minion attack

    // play card
    if( isset($command['hand']) ) {
    }

    // end turn
    if( isset($command['end']) ) {
      $this->switchSide();
      $this->result[] = 'end';
    }

    return $this->result;
  }

  public function state()
  {
    // send to client on create game and on reconnect
    return 'game create/reconnect';
  }

  private function getTarget($command)
  {
    // Hero
    if (isset($command['self'])) {
      return $this->fs['hero'];
    }
    // Hero
    if (isset($command['opponent'])) {
      return $this->es['hero'];
    }
    // Card
    if (isset($command['fMinion'])) {
      return $this->fs['minions']->getByIndex($command['fMinion']);
    }
    // Card
    if (isset($command['eMinion'])) {
      return $this->es['minions']->getByIndex($command['eMinion']);
    }

    // Card Collection
    if (isset($command['position'])) {
      return $this->fs['minions']->setTargetPosition($command['position']);
    }

    throw new ClientException("Not found target for command:" . json_encode($command));
  }
}
