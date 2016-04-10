<?php

include('src/Game.php');
include('src/Connect.php');
include('src/Heroes/Hunter.php');
include('src/Heroes/Mage.php');

//      INIT
$cards = include('migrations/Demo.php');
$deck1 = [
  'Маназмей','Зеркальные копии','Чародейские стрелы',
  'Интеллект чародея','Огненный шар', 'Яйцо дракона',
  'Солдат Златоземья', 'Раздражатор', 'Маг Даларана',
];
$deck2 = [
  'Чародейский выстрел', 'Тенетник', 'Взрывная ловушка',
  'Гиена-падальщица', 'Смертельный выстрел', 'Мурлок-налетчик',
  'Воин Синежабрых', 'Боец Северного Волка', 'Железноклюв',
];
foreach ($deck1 as $key => $name) {
  foreach ($cards as $card) {
    if ($card['nm'] == $name) {
      $deck1[$name] = $card;
    }
  }
}
foreach ($deck2 as $key => $name) {
  foreach ($cards as $card) {
    if ($card['nm'] == $name) {
      $deck2[$name] = $card;
    }
  }
}
var_dump($deck1);
var_dump($deck2);
die();

$hero1 = new Hunter();
$hero2 = new Mage();
// debug print logs in out
$game = new Game($deck1, $deck2, $hero1, $hero2, $debug = true);

$connect = new Connect();
$game->handleConnect($connect);

//      SCENARIO AND CHECKS

// select keys: 'power', 'attack', 'hand', 'minion', 'end'
// target keys: 'self', 'opponent', 'fMinion', 'eMinion', 'position'

//1
$connect->send(['hand' => 2, 'position' => 1]);
$connect->send(['end' => true]);
$connect->send(['hand' => 1, 'eMinion' => 1]);
$connect->send(['end' => true]);

//2
