<?php

namespace Cardgame;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Cardgame\Game;

require('../vendor/autoload.php');

class Connection implements MessageComponentInterface {
    protected $clients;
    protected $game = null;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
      $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
      $msg = json_decode($msg, true);

      if ($this->game) {
        $result = $this->game->command($msg);
      } else {
        $this->game = new Game($msg, true);
        $result = $this->game->state();
      }

      // send result to ALL clients
      foreach ($this->clients as $client) {
        $client->send(json_encode($result));
      }
    }

    public function onClose(ConnectionInterface $conn) {
      // $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
      echo $e->getMessage();
      $conn->close();
    }
}
