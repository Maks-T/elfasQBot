<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\DB\JsonDB;

class UserRepository
{
  const FILE_PATH =  __DIR__ . './../Store/users.json';

  private JsonDb $jsonDB;

  public function __construct()
  {
    $this->jsonDB = new JsonDB(self::FILE_PATH, User::class);
  }

  public function create(User $user): ?User
  {
    $findUser = $this->getUserById($user->id);

    if (!$findUser) {
      return $this->jsonDB->create($user);
    }

    return null;
  }


  /**
   * @return User[]
   */
  public function getAll(): array
  {
    return $this->jsonDB->getAll();
  }

  public function getUserById(int $id): ?User
  {
    return $this->jsonDB->getByField('id', $id);
  }

  public function updateUserById(int $id, object $User): ?User
  {
    $findUser = $this->getUserById($id);

    if ($findUser) {
      return $this->jsonDB->updateByField('id', $id, new User($User));
    }

    return null;
  }

  public function deleteUserById(int $id): ?User
  {
    $findUser = $this->getUserById($id);

    if ($findUser) {
      return $this->jsonDB->deleteByField('id', $id);
    }

    return null;
  }
}
