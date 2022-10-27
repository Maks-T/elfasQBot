<?php

declare(strict_types=1);

namespace App\DB\Models;

class Ques
{
  public string $id;
  public string $question;
  public string $topic;
  public array $level;

  public function __construct(array $quesData)
  {
    $this->id = $quesData['id'];
    $this->question = $quesData['question'];
    $this->topic = $quesData['topic'];
    $this->level = $quesData['level'];
  }
}
