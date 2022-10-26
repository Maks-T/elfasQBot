<?php

require '../vendor/autoload.php';

const API_TOKEN = '5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ';

try {
  $bot = new \TelegramBot\Api\Client('5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ');

  // or initialize with botan.io tracker api key
  // $bot = new \TelegramBot\Api\Client('YOUR_BOT_API_TOKEN', 'YOUR_BOTAN_TRACKER_API_KEY');


  //Handle /ping command
  $bot->command('start', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(), 'Hello!');
  });

  //Handle /ping command
  $bot->command('ping', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(), 'pong!');
  });

  //Handle text messages
  $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
    $message = $update->getMessage();
    $id = $message->getChat()->getId();
    $bot->sendMessage($id, 'Your message: ' . $message->getText());
  }, function () {
    return true;
  });

  $bot->run();
} catch (\TelegramBot\Api\Exception $e) {
  $e->getMessage();
}
