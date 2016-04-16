<?php

namespace Cardgame;

use Cardgame\Cards\Deck;
use Cardgame\Cards\Hand;
use Cardgame\Cards\Minions;
use Cardgame\Cards\Gone;

use Cardgame\Exceptions\ClientException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class Game
{
  private $top = [];
  private $bottom = [];
  private $fs; // friendlySide
  private $es; // enemySide
  private $debug = false;
  private $result = [];

  private $ed; // eventDispatcher

  function __construct($createMsg, $debug)
  {
    $this->debug = $debug;
    $this->ed = new EventDispatcher();

    // example
    $this->ed->addListener('game.start', function (Event $event) {
      echo 'event!';
    });
    $this->ed->dispatch('game.start');
    $ls = $this->ed->getListeners('game.start');
    foreach ($ls as $listener) {
      $this->ed->removeListener('game.start', $listener);
    }
    $this->ed->dispatch('game.start');


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

    // select side
    if (mt_rand(0,1)) {
      $this->fs = $this->bottom;
      $this->es = $this->top;
    } else {
      $this->fs = $this->top;
      $this->es = $this->bottom;
    }

    // TODO: mulligan and coin
    $this->fs['hand']->pushCard( $this->fs['deck']->pullCardRand(3) );
    $this->es['hand']->pushCard( $this->es['deck']->pullCardRand(3) );
  }

  private function switchSide()
  {
    list($this->fs, $this->es) = [$this->es, $this->fs];
  }

  public function command($command)
  {
    $this->result = [];

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
      $target = $this->getTarget($command);
      $card = $this->fs['hand']->get($command['hand']);
      $this->result[] = $card->play($this, $target);
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

    // null target
    return null;
  }
}
