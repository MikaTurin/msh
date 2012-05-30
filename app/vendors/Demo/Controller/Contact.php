<?php
/**
 * primer dinamicheskogo actiona
 * na etoj osnove mozhno budet postroitj controller
 * kotorij budet chitatj action iz failov kak v versiji dlja Ambergames
 */
class Demo_Controller_Contact extends Msh_Controller {

  public function __construct($uri) {

    parent::__construct($uri);
    $this->method = null;
    if ($this->action == 'index') $this->method = 'index';
    elseif (!sizeof($this->params) && in_array($this->action, $this->getList())) $this->method = 'services';
  }

  protected function getList() {

    return array(
      'voice_communication',
      'mobile_internet',
      'call_waiting',
      'voice_mail',
      'call_forwarding'
    );
  }

  public function index() {

    $r = $this->getList();
    Msh::getInstance()->response()->redirectWithLang('/contact/'.array_shift($r), 301); //301 for seo
  }

  public function services() {

    $this->view()->assign('list', $this->getList());
    $this->view()->assign('current', $this->action);
    $this->view()->assign('page', 'contact');
    $this->view()->display('list.tpl');
  }
}