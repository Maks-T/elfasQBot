<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\AppException;
use App\Repositories\QuesRepository;


class HomeController
{
  public function __construct()
  {
  }

  public function index()
  {
    echo '<h1>home page</h1>';
  }
}
