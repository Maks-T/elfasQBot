<?php

declare(strict_types=1);

namespace App\Models;

class User
{
  public int $id;
  public string $first_name;
  public string $last_name;
  public string $username;

  public function __construct($userData)
  {
    $this->id = $userData->id;
    $this->first_name = $userData->first_name;
    $this->last_name = $userData->last_name;
    $this->username = $userData->username;
  }
}
