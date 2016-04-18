<?php

use Symfony\Component\EventDispatcher\Event;


return [
  [
    'id' => '1',
    'nm' => 'Маназмей',
    'cs' => 1,
    'at' => 1,
    'hp' => 3,
    'cl' => 'mage',
    'rr' => 'common',
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target) {
      $game->ed->addListener('play.friendlySpell', function (Event $event) use ($card, $game) {
        $card->modAttack(1);
        $game->result[] = 'inc attack for ' . $card->getPosition() . ' friendly';
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '2',
    'nm' => 'Зеркальные копии',
    'cs' => 1,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $card = $game->createMinion($id = 20);
      $game->fs['minions']->pushMinion($card);
      $game->fs['minions']->pushMinion($card);
      $game->result[] = 'summon 2 minion ' . $card->getId();
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '3',
    'nm' => 'Чародейские стрелы',
    'cs' => 1,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      for ($i=0; $i < 3; $i++) {
        $enemyesCount = count($game->es['minions']->select()) + 1; // enemy hero
        $targetPosition = mt_rand(1, $enemyesCount);
        if ($targetPosition == $enemyesCount) {
          $game->es['hero']->damage(1);
          $game->result[] = 'damage enemy hero';
        } else {
          $minion = $game->es['minions']->getByPosition($targetPosition);
          $game->result[] = 'damage ' . $targetPosition . ' enemy minion';
          $minion->damage(1);
        }
      }
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '4',
    'nm' => 'Интеллект чародея',
    'cs' => 3,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $this->fs['hand']->pushCards( $this->fs['deck']->pullCardRand(2) );
      $game->result[] = 'get to 2 card!';
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '5',
    'nm' => 'Огненный шар',
    'cs' => 4,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      echo get_class($target);
      $target->damage(6);
      $game->result[] = '6 point damage!';
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '6',
    'nm' => 'Чародейский выстрел',
    'cs' => 1,
    'cl' => 'hunter',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      echo get_class($target);
      $target->damage(2);
      $game->result[] = '2 point damage!';
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '7',
    'nm' => 'Тенетник',
    'cs' => 1,
    'at' => 1,
    'hp' => 1,
    'cl' => 'hunter',
    'rr' => 'basic',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $game->ed->addListener('die.friendlyMinion', function (Event $event) use ($card, $game) {
        if ($event->getDieMinion() == $card) {
          foreach ($game->cardSet as $card) {
            if ( in_array('beast', $card['rs']) ) {
              $beast = new Card($card);
              $game->fs['hand']->pushCards([$beast]);
              $game->result[] = 'rand beast add to hand';
              return;
            }
          }
        }
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '8',
    'nm' => 'Взрывная ловушка',
    'cs' => 2,
    'cl' => 'hunter',
    'rr' => 'common',
    'rs' => ['secret'],
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $game->ed->addListener('attack.Hero', function (Event $event) use ($card, $game) {
        foreach ($game->fs['minions'] as $minion) {
          $minion->damage(2);
        }
        $game->fs['hero']->damage(2);
        $game->result[] = 'secret: damage 2 points all friendly character';
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '9',
    'nm' => 'Гиена-падальщица',
    'cs' => 2,
    'at' => 2,
    'hp' => 2,
    'cl' => 'hunter',
    'rr' => 'common',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $game->ed->addListener('die.friendlyBeast', function (Event $event) use ($card) {
        $card->modAttack(2);
        $card->modHealth(1);
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '10',
    'nm' => 'Смертельный выстрел',
    'cs' => 3,
    'cl' => 'hunter',
    'rr' => 'common',
    'im' => false,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $enemyesCount = count($game->es['minions']->select());
      if ($enemyesCount == 0) {
        // TODO: impossible action!
        return;
      }
      $targetPosition = mt_rand(1, $enemyesCount);
      $minion = $game->es['minions']->getByPosition($targetPosition);
      $minion->kill();
      $game->result[] = 'kill ' . $targetPosition . ' enemy minion';
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '11',
    'nm' => 'Яйцо дракона',
    'cs' => 1,
    'at' => 0,
    'hp' => 2,
    'rr' => 'rare',
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $game->ed->addListener('attack.friendlyMinion', function (Event $event) use ($card, $game) {
        if ($event->getAttackMinion() == $card) {
          $card = $game->createMinion($id = 19);
          $game->fs['minions']->pushMinion($card);
          $game->result[] = 'summon minion: ' . $card->getId();
        }
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '12',
    'nm' => 'Мурлок-налетчик',
    'cs' => 1,
    'at' => 2,
    'hp' => 1,
    'rr' => 'basic',
    'rs' => ['murloc'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '13',
    'nm' => 'Солдат Златоземья',
    'cs' => 1,
    'at' => 1,
    'hp' => 2,
    'rr' => 'basic',
    'ef' => ['taunt'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '14',
    'nm' => 'Раздражатор',
    'cs' => 2,
    'at' => 1,
    'hp' => 2,
    'rr' => 'common',
    'ef' => ['taunt', 'shield'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '15',
    'nm' => 'Воин Синежабрых',
    'cs' => 2,
    'at' => 2,
    'hp' => 1,
    'rr' => 'basic',
    'rs' => ['murloc'],
    'ef' => ['charge'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '16',
    'nm' => 'Боец Северного Волка',
    'cs' => 2,
    'at' => 2,
    'hp' => 2,
    'rr' => 'basic',
    'ef' => ['taunt'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '17',
    'nm' => 'Железноклюв',
    'cs' => 2,
    'at' => 2,
    'hp' => 1,
    'rr' => 'common',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      // doubleTarget!
      $target[1]->silence();
      $game->result[] = 'silense minion: ' . $target[1]->getId();
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '18',
    'nm' => 'Маг Даларана',
    'cs' => 3,
    'at' => 1,
    'hp' => 4,
    'rr' => 'basic',
    'im' => true,
    'ih' => false,
    'cb' => function($game, $card, $target){
      $this->fs['hero']->modSpellDamage(1);
      $game->result[] = 'spell damage inc';

      $game->ed->addListener('die.friendlyMinion', function (Event $event) use ($card, $game) {
        if ($event->getDieMinion() == $card) {
          $this->fs['hero']->modSpellDamage(-1);
          $game->result[] = 'spell damage dec';
        }
      });
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '19',
    'nm' => 'Черный дракончик',
    'cs' => 1,
    'at' => 2,
    'hp' => 1,
    'rr' => 'common',
    'rs' => ['dragon'],
    'im' => true,
    'ih' => true,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
  [
    'id' => '20',
    'nm' => 'Зеркальная копия',
    'cs' => 0,
    'at' => 0,
    'hp' => 2,
    'rr' => 'common',
    'rs' => ['taunt'],
    'im' => true,
    'ih' => true,
    'cb' => function($game, $card, $target){
      return $card->getName() . ' played';
    }
  ],
];
