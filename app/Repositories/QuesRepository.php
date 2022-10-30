<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Ques;
use App\DB\JsonDB;

class QuesRepository
{
  const FILE_PATH =  __DIR__ . './../Store/ques.json';

  private JsonDb $jsonDB;

  public function __construct()
  {
    $this->jsonDB = new JsonDB(self::FILE_PATH, Ques::class);
  }

  /**
   * @return Ques[]
   */
  public function getAll(): array
  {
    return $this->jsonDB->getAll();
  }

  public function createAll(array $quesData): ?array
  {
    $curId = $this->jsonDB->getLastId();
    $quesModels = [];

    foreach ($quesData as $ques) {
      $ques->id = ++$curId;
      $quesModels[] = new Ques($ques);
    }

    return $this->jsonDB->createAll($quesModels);
  }

  public function getQuesById(int $id): ?Ques
  {
    return $this->jsonDB->getByField('id', $id);
  }

  public function updateQuesById(int $id, object $ques): ?Ques
  {
    $findQues = $this->getQuesById($id);

    if ($findQues) {
      return $this->jsonDB->updateByField('id', $id, new Ques($ques));
    }

    return null;
  }

  public function deleteQuesById(int $id): ?Ques
  {
    $findQues = $this->getQuesById($id);

    if ($findQues) {
      return $this->jsonDB->deleteByField('id', $id);
    }

    return null;
  }
}
