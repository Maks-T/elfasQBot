<?php

declare(strict_types=1);

namespace App;

use \TelegramBot\Api\Client;


class Bot
{
  const BOT_API_TOKEN = '5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ';

  private Client $bot;

  public function __construct()
  {
    $this->bot = new Client(self::BOT_API_TOKEN);
    $this->createCommands();
  }

  private function createCommands()
  {
    try {
      //Handle /start command
      $this->bot->command('start', function ($message) {
        $this->bot->sendMessage($message->getChat()->getId(), 'Hello! 1' . $message->getFrom()->getFirstName());
      });

      //Handle /ping command
      $this->bot->command('next', function ($message) {
        $this->bot->sendMessage($message->getChat()->getId(), $message->getFrom()->getFirstName());
      });

      //Handle text messages
      $this->bot->on(function (\TelegramBot\Api\Types\Update $update) {
        $message = $update->getMessage();
        $id = $message->getChat()->getId();
        $this->bot->sendMessage($id, 'Your message: ' . $message->getText());
      }, function () {
        return true;
      });

      $this->bot->run();
    } catch (\TelegramBot\Api\Exception $e) {
      $e->getMessage();
    }
  }
}
