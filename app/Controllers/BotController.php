<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\AppException;
use App\Repositories\QuesRepository;
use App\Bot;

class BotController
{
  private Bot $bot;

  public function __construct()
  {
    $this->bot = new Bot();
  }

  public function index()
  {
  }
}
