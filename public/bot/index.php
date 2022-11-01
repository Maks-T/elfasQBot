<?php

declare(strict_types=1);

try {
  $bot = new \TelegramBot\Api\Client('5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ');

  //Handle /start command
  $bot->command('start', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(), 'Hello! ' . $message->getFrom()->getFirstName());
  });

  //Handle /ping command
  $bot->command('next', function ($message) use ($bot) {
    $bot->sendMessage($message->getChat()->getId(),  $message->getFrom()->getFirstName());
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
