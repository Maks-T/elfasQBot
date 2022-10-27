<?php

declare(strict_types=1);

namespace App\Exceptions;

class AppException
{

  const ROURE_NOT_FOUND = 1;
  const BAD_REQUEST = 400;
  const NOT_FOUND = 404;
  const INTERNAL_SERVER_ERROR = 500;

  public function __construct()
  {
    set_exception_handler(array($this, 'exception_handler'));
  }

  public function exception_handler($e)
  {
    switch ($e->getCode()) {
      case self::ROURE_NOT_FOUND:
        http_response_code(self::NOT_FOUND);
        echo $e->getMessage();
        break;
      case self::BAD_REQUEST:
      case self::NOT_FOUND:
      case self::INTERNAL_SERVER_ERROR:
      default:
        http_response_code($e->getCode());
        echo $e->getMessage();
        break;
    }
  }

  public static function fatalMessage(): string
  {
    return json_encode(['status' => 'fatal']);
  }
}
