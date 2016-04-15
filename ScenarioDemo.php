<?php

include('vendor/autoload.php');

//      INIT
include('ws/WsClient.php');
$cards = include('decks/Demo.php');

$deckA = [
  '1','2','3','4','5','6', '13', '14', '18'
];
$deckB = [
  '7', '8','9','10','11','12', '15', '16', '17'
];

// foreach ($deckA as $key => $id) {
//   foreach ($cards as $card) {
//     if ($card['id'] == $id) {
//       unset($deckA[$key]);
//       $deckA[] = $card;
//     }
//   }
// }
// foreach ($deckB as $key => $id) {
//   foreach ($cards as $card) {
//     if ($card['id'] == $id) {
//       unset($deckB[$key]);
//       $deckB[] = $card;
//     }
//   }
// }

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
];
// loop
$wc = new WsClient(['Hunter' => $deckA, 'Mage' => $deckB], $scenario);
