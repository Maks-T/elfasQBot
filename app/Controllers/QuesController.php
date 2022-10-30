<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\AppException;
use App\Repositories\QuesRepository;

class QuesController extends Controller
{

  private QuesRepository $quesRepository;

  public function __construct()
  {
    parent::__construct();
    $this->quesRepository = new QuesRepository();
  }

  public function createAll(): void
  {
    $quesData = $this->request->getData();
    //$this->checkUserData($quesData)
    echo json_encode($this->quesRepository->createAll($quesData));
  }

  public function getAll(): void
  {

    echo json_encode($this->quesRepository->getAll());
  }

  public function get(int $id): void
  {

    echo json_encode($this->quesRepository->getQuesById($id));
  }

  public function update(int $id): void
  {
    $quesData = $this->request->getData();
    //$this->checkUserData($quesData)
    echo json_encode($this->quesRepository->updateQuesById($id, $quesData));
  }

  public function delete(int $id): void
  {
    echo json_encode($this->quesRepository->deleteQuesById($id));
  }

  public function checkUserData($data): void
  {
  }
}
