<?php
class Msh_Router extends Slim_Router {

  /**
   * @param $pattern
   * @param $class
   * @return Msh_Route
   */
  public function mapController ( $pattern, $class ) {

    $route = new Msh_Route($pattern, $class);
    $route->setRouter($this);
    $this->routes[] = $route;
    return $route;
  }
}