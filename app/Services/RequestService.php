<?php

namespace App\Services;

class RequestService
{
  public function getData()
  {
    $req = json_decode(file_get_contents('php://input'));

    /*$data = [];
    foreach ($req as $field => $valueField) {
      $data[$field] = str_replace(" ", "", $valueField);
    }*/

    return $req;
  }
}
