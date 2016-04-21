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
  private $cardSet;
  private $top = [];
  private $bottom = [];
  private $fs; // friendlySide
  private $es; // enemySide
  private $debug = false;

  public $result = [];

  private $ed; // eventDispatcher

  function __construct($createMsg, $debug)
  {
    $this->debug = $debug;
    $this->ed = new EventDispatcher();

    // example dispatch and delete listeners
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
    $this->cardSet = require('../sets/Demo.php');

    $this->top = [
      'hero' => new $classNameB(),
      'deck' => new Deck($deckB, $this->cardSet),
      'hand' => new Hand([]),
      'minions' => new Minions([]),
      'gone' => new Gone([]),
    ];
    $this->bottom = [
      'hero' => new $classNameA(),
      'deck' => new Deck($deckA, $this->cardSet),
      'hand' => new Hand([]),
      'minions' => new Minions([]),
      'gone' => new Gone([]),
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
    $this->fs['hand']->pushCards( $this->fs['deck']->pullCardRand(4) );
    $this->es['hand']->pushCards( $this->es['deck']->pullCardRand(3) );
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
      // TODO: check use conditions

      $card = $this->fs['hand']->pullCard($command['hand']);
      // target in Hero, Minion or int position
      $target = $this->getTarget($command, $card);
      if ($card->isMinion) {
        $this->fs['minions']->setMinion($card, $target);
      }
      $this->result[] = $card->play($this, $target);
    }

    // end turn
    if( isset($command['end']) ) {
      $this->switchSide();
      // TODO: corpse GC >=)
      $this->result[] = 'end';
      // debug
      $this->printState();

      // get card in start turn
      $this->fs['hand']->pushCards( $this->fs['deck']->pullCardRand(1) );
    }

    return $this->result;
  }

  public function state()
  {
    // send to client on create game and on reconnect
    return ['game create/reconnect'];
  }

  private function getTarget($command, $card)
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
      return $this->fs['minions']->getByPosition($command['fMinion']);
    }
    // Card
    if (isset($command['eMinion'])) {
      return $this->es['minions']->getByPosition($command['eMinion']);
    }

    // int (always minion!)
    if (isset($command['position'])) {
        return $command['position'];
    }

    var_dump('undefined command');
    die();
  }

  public function createMinion($selector)
  {
    if (is_int($selector)) {
      foreach ($this->cardSet as $card) {
        if ($card['id'] == $selector) {
          return new Card($card);
        }
      }
    }
    // TODO: other selectors
  }

  // debug
  public function printState()
  {
    $state = [
      'top' => [
        'hero' => $this->top['hero']->getStats(),
        'deck' => count($this->top['deck']->select()),
        'hand' => count($this->top['hand']->select()),
        'minions' => count($this->top['minions']->select()),
        'gone' => count($this->top['gone']->select()),
      ],
      'bottom' => [
        'hero' => $this->bottom['hero']->getStats(),
        'deck' => count($this->bottom['deck']->select()),
        'hand' => count($this->bottom['hand']->select()),
        'minions' => count($this->bottom['minions']->select()),
        'gone' => count($this->bottom['gone']->select()),
      ]
    ];
    print_r($state['top']['hero'] . "\n");
    print_r($state['top']['deck'].':'.$state['top']['hand'].':'.$state['top']['minions'].':'.$state['top']['gone'] . "\n");
    print_r($this->top['hand']->exportNames());
    print_r($this->top['minions']->exportNames());
    print_r("\n");
    print_r($state['bottom']['hero'] . "\n");
    print_r($state['bottom']['deck'].':'.$state['bottom']['hand'].':'.$state['bottom']['minions'].':'.$state['bottom']['gone'] . "\n");
    print_r($this->bottom['hand']->exportNames());
    print_r($this->bottom['minions']->exportNames());
    print_r("\n");
    print_r("\n");
  }
}
