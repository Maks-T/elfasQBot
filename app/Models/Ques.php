<?php

declare(strict_types=1);

namespace App\Models;

class Ques
{
  public int $id;
  public string $ques;
  public string $topic;
  public string $level;

  public function __construct($quesData)
  {
    $this->id = (int)$quesData->id;
    $this->ques = $quesData->ques;
    $this->topic = $quesData->topic;
    $this->level = $quesData->level;
  }
}
