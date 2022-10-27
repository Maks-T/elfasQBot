<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\RequestService;


abstract class Controller
{
  protected RequestService $request;

  public function __construct()
  {
    $this->request = new RequestService();
  }
}
