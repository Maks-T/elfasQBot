<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DB\Model\Ques;
use App\Exceptions\AppException;

class QuesController extends Controller
{


  public function __construct()
  {
    parent::__construct();
  }

  public function create(): void
  {
    $quesData = $this->request->getData();
    //$this->checkUserData($quesData);
    var_dump($quesData);
  }

  public function get(): void
  {
    echo "gett";
  }

  public function update(): void
  {
  }

  public function delete(): void
  {
  }

  public function checkUserData($data): void
  {
  }
}
