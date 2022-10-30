<?php

declare(strict_types=1);

namespace App\DB;

use App\Exceptions\AppException;

class JsonDB
{
  private string $path;

  /** @var object[] $items */
  private array $items = [];

  public function __construct(string $path, string $class)
  {
    $this->path = $path;
    $json = file_get_contents($this->path);
    $itemsJson = json_decode($json) ?? [];

    foreach ($itemsJson as $itemJson) {
      $this->items[] = new $class($itemJson);
    }
  }

  public function getSize(): int
  {
    return count($this->items);
  }

  public function getLastId(): int
  {
    return
      count($this->items) !== 0
      ? $this->items[count($this->items) - 1]->id
      : 0;
  }

  public function createAll(array $items): ?array
  {
    try {
      array_push($this->items, ...$items);
      $this->saveItemsToFile();

      return $items;
    } catch (\Exception $e) {
      throw new \Error(
        AppException::fatalMessage(),
        AppException::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function create(object $item): ?object
  {
    try {
      $this->items[] = $item;
      $this->saveItemsToFile();

      return $item;
    } catch (\Exception $e) {
      throw new \Error(
        AppException::fatalMessage(),
        AppException::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function getByField(string $field, mixed $value): ?object
  {
    foreach ($this->items as $itemFind) {
      if (isset($itemFind->$field)) {
        if ($itemFind->$field == $value) {

          return $itemFind;
        }
      }
    }

    return null;
  }

  public function updateByField(string $field, mixed $value, object $item): ?object
  {
    try {
      foreach ($this->items as $index => $itemFind) {
        if (isset($itemFind->$field)) {
          if ($itemFind->$field == $value) {

            $this->items[$index] = $item;
          }
        }
      }
      $this->saveItemsToFile();

      return $item ?? null;
    } catch (\Exception $e) {
      throw new \Error(
        json_encode(['status' => 'fatal']),
        AppException::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function deleteByField(string $field, mixed $value): ?object
  {
    try {

      foreach ($this->items as $index => $itemFind) {
        if (isset($itemFind->$field)) {
          if ($itemFind->$field == $value) {
            $item = $itemFind;
            array_splice($this->items, $index, 1);
          }
        }
      }

      $this->saveItemsToFile();

      return $item ?? null;
    } catch (\Exception $e) {
      throw new \Error(
        AppException::fatalMessage(),
        AppException::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function getAll(): array
  {
    return $this->items;
  }

  public function saveItemsToFile()
  {
    try {
      $json = json_encode($this->items);
      file_put_contents($this->path, $json);
    } catch (\Exception $e) {
      throw new \Error(
        AppException::fatalMessage(),
        AppException::INTERNAL_SERVER_ERROR
      );
    }
  }
}
