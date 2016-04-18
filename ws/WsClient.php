<?php

require('vendor/autoload.php');

class WsClient
{
  function __construct(array $decks, array $scenario)
  {
    $loop = React\EventLoop\Factory::create();
    $conn = new Ratchet\Client\Connector($loop);

    $conn('ws://127.0.0.1:8080')
      ->then(function(Ratchet\Client\WebSocket $conn) use ($decks, $scenario) {
          // setup
          $conn->send(json_encode($decks));

          // scenario
          foreach ($scenario as $command) {
            $send = json_encode($command);
            $conn->send($send);
          }

          $conn->on('message', function($msg) use ($conn) {
            $results = json_decode($msg, true);
            foreach ($results as $result) {
              echo $result . "\n";
            }
          });
          $conn->on('close', function($code, $reason) {
            echo "Connect close. Code: $code, Reason: $reason\n";
          });

      }, function(\Exception $e) use ($loop) {
          echo "Could not connect: {$e->getMessage()}\n";
          $loop->stop();
      });
    $loop->run();
  }
}
