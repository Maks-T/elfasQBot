<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\AppException;

class Router
{
  private array $routes = [];

  private array $condRoutes = [];

  public function register(string $requestMethod, string $route, array $action): self
  {
    $this->routes[$requestMethod][$route] = $action;

    if (strpos($route, ':')) {
      $this->condRoutes[] = $route;
    }

    return $this;
  }

  public function get(string $route, array $action): self
  {
    $this->register('get', $route, $action);

    return $this;
  }

  public function post(string $route, array $action): self
  {
    $this->register('post', $route, $action);

    return $this;
  }

  public function put(string $route, array $action): self
  {
    $this->register('put', $route, $action);

    return $this;
  }

  public function delete(string $route, array $action): self
  {
    $this->register('delete', $route, $action);

    return $this;
  }


  /**
   * @throws \Exception
   */
  public function resolve(string $requestUri, string $requestMethod)
  {
    $route = explode('?', $requestUri)[0];

    $condRoute = $this->matchRoute($route);

    if ($condRoute) {
      $action = $this->routes[$requestMethod][$condRoute['route']] ?? null;
    } else {
      $action = $this->routes[$requestMethod][$route] ?? null;
    }

    if (!$action) {
      throw new \Exception("", AppException::ROURE_NOT_FOUND);
    }

    [$class, $method, $contentType] = $action;

    if (class_exists($class)) {
      $class = new $class;

      header("Content-Type: $contentType");

      if (method_exists($class, $method)) {
        return $condRoute
          ? call_user_func_array([$class, $method], [$condRoute['value']])
          :
          call_user_func_array([$class, $method], []);
      }
    }

    throw new \Exception("", AppException::ROURE_NOT_FOUND);
  }

  private function matchRoute(string $route): ?array
  {
    $baseRoute = substr($route, 0, strripos($route, '/'));

    foreach ($this->condRoutes as $condRoute) {
      $baseCondRoute = substr($condRoute, 0, strripos($condRoute, '/'));
      if ($baseRoute == $baseCondRoute) {
        $key = substr($condRoute, strpos($condRoute, ':') + 1);
        $value = substr($route, strripos($route, '/') + 1);

        return ['key' => $key, 'value' => $value, 'route' => $condRoute];
      }
    }

    return null;
  }
}
