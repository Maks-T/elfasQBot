<?php

require '../vendor/autoload.php';

use App\Router;
use App\Controllers\QuesController;
use App\Controllers\HomeController;
use App\Controllers\BotController;
use App\Repositories\UserRepository;
use App\Models\User;


$userRepository = new UserRepository();

try {
  $bot = new \TelegramBot\Api\Client('5754083770:AAEXAmcQDliA23LesKLbKkZWShi0OzG5oYQ');

  //Handle /start command
  $bot->command('start', function ($message) use ($bot, $userRepository) {
    // $bot->sendMessage($message->getChat()->getId(), 'Hello! ' . $message->getFrom()->getFirstName());

    $userData = (object)[
      "id" => $message->getFrom()->getId(),
      "first_name" => $message->getFrom()->getFirstName(),
      "last_name" => $message->getFrom()->getLastName(),
      "username" => $message->getFrom()->getUsername()
    ];

    $user = new User($userData);

    $userCreated = $userRepository->create($user);

    if ($userCreated) {
      $bot->sendMessage($message->getChat()->getId(), 'Hello! ' . $message->getFrom()->getFirstName());
    } else {
      $bot->sendMessage($message->getChat()->getId(), 'You are already registered');
    }
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

$router = new Router();

$router->get('/', [HomeController::class, 'index', 'text/html']);
$router->get('/bot', [BotController::class, 'index', 'text/html']);
$router->get('/api/ques', [QuesController::class, 'getAll', 'application/json']);
$router->get('/api/ques/:id', [QuesController::class, 'get', 'application/json']);
$router->post('/api/ques', [QuesController::class, 'createAll', 'application/json']);
$router->put('/api/ques/:id', [QuesController::class, 'update', 'application/json']);
$router->delete('/api/ques/:id', [QuesController::class, 'delete', 'application/json']);

//CHANGE REQUEST_URI
$_SERVER['REQUEST_URI'] = str_ireplace('/elfasQBot', '', $_SERVER['REQUEST_URI']);
if (strlen($_SERVER['REQUEST_URI']) > 1) {
  $_SERVER['REQUEST_URI'] = preg_replace("#/$#", "", $_SERVER['REQUEST_URI']);
}

$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
