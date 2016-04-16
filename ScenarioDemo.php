<?php

include('vendor/autoload.php');

//      INIT
include('ws/WsClient.php');
$cards = include('decks/Demo.php');

$deckA = [
  '1','2','3','4','5','6','13','14','18'
];
$deckB = [
  '7','8','9','10','11','12','15','16','17'
];

//      SCENARIO AND CHECKS

// select keys: 'power', 'attack', 'hand', 'minion', 'end'
// target keys: 'self', 'opponent', 'fMinion', 'eMinion', 'position'

$scenario = [
  //1
  ['hand' => 2, 'position' => 1],
  ['end' => true],
  ['hand' => 1, 'eMinion' => 1],
  ['end' => true],
  //2
  ['hand' => 2, 'position' => 1],
  ['end' => true],
  ['power' => true, 'eMinion' => 1],
  ['end' => true],
];
// loop
$wc = new WsClient(['Hunter' => $deckA, 'Mage' => $deckB], $scenario);
