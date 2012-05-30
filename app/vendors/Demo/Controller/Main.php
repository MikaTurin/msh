<?php
class Demo_Controller_Main extends Msh_Controller {

  public function init() {

    $this->view()->assign('page', $this->action);
    $this->view()->display('text.tpl');
  }

  public function index() {

  }

  public function coding() {

  }

  public function styles() {

  }

  protected function cantCallThisFromUrl() {

    echo 'never will be seen public';
  }
}