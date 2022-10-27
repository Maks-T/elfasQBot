<?php

require '../vendor/autoload.php';

use App\Router;
use App\Controllers\QuesController;

const API_TOKEN = '5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ';

$router = new Router();

var_dump($_SERVER['REQUEST_URI']);
$router->get('/api/ques', [QuesController::class, 'get']);
$router->post('/api/ques', [QuesController::class, 'create']);

$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));




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