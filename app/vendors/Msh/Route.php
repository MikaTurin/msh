<?php
class Msh_Route extends Slim_Route {

  public function getControllerUri() {

    $uri = $this->router->getRequest()->getResourceUri();
    return trim(str_ireplace(substr($this->pattern, 0, -2), '', $uri), '/');
  }

  public function dispatch() {

    if (substr($this->pattern, -1) === '/' && substr($this->router->getRequest()->getResourceUri(), -1) !== '/') {
      throw new Slim_Exception_RequestSlash();
    }

    //Invoke middleware
    $req = $this->router->getRequest();
    $res = $this->router->getResponse();
    foreach ($this->middleware as $mw) {
      if (is_callable($mw)) {
        call_user_func_array($mw, array($req, $res, $this));
      }
    }

    //Invoke callable
    $controller = new $this->callable($this->getControllerUri());

    if ($controller->method) {

      if (method_exists($controller, 'init')) call_user_func(array($controller, 'init'));
      call_user_func_array(array($controller, $controller->method), array_values($this->params));
      return true;
    }
    return false;
  }
}