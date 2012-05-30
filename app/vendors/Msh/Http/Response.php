<?php
class Msh_Http_Response extends Slim_Http_Response {

  public function redirectWithLang($url, $status = 302 ) {

    $lurl = Msh::getInstance()->config('LURL');
    $this->redirect($lurl.$url, $status);
  }
}