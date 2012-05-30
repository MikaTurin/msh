<?php
class Msh_Controller {

  protected $params;
  protected $action;
  public $method;

  public function __construct($uri) {

    $this->params = explode('/', $uri);
    $this->action = array_shift($this->params);
    if ($this->action == 'index') return;
    if (!$this->action) $this->action = 'index';
    if (!method_exists($this, $this->action)) return;
    $o = new ReflectionMethod($this, $this->action);
    if (!sizeof($this->params) && $o->isPublic()) $this->method = $this->action;
  }

  /**
   * @static
   * @return Smarty
   */
  protected function view() {

    return Msh::getInstance()->view()->smarty();
  }
}