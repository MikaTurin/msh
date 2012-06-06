<?php
class Msh_Controller_Admin extends Msh_Controller {

  public function index() {

    if (Msh_Admin::in()) {
      Msh::getInstance()->response()->redirectWithLang('/');
      return;
    }

    $this->view()->display('admin/login.tpl');
  }

  public function login() {

    $req = Msh::getInstance()->request();
    Msh_Admin::login($req->post('usr'), $req->post('pwd'));
    Msh::getInstance()->response()->redirectWithLang('/admin');
  }

  public function logout() {

    Msh_Admin::logout();
    Msh::getInstance()->response()->redirectWithLang('/admin');
  }

  public function editor() {

    $mode = Msh::getInstance()->request()->get('mode');

    if ($mode == 'off') {
      Msh_Admin::editorHide();
    }
    else {
      Msh_Admin::editorShow();
    }

    Msh::getInstance()->response()->redirectWithLang('/');
  }

  public function save() {

    $r = $ptype = null;
    $lng = Msh::getInstance()->getLanguage();
    if (isset($_POST['content'])) $r = json_decode($_POST['content'], true);

    if (!$r) die('error no content');
    if (isset($r['pagetype'])) $ptype = $r['pagetype'];

    if (1) {

      foreach ($r as $id => $a) {

        if (!$id) die('error no id');
        if ($id == 'snippets') continue;

        if (!isset($a['value'])) die('error no value: '.$id);

        $s = addslashes($a['value']);
        Sql::query("REPLACE `translations` SET id='{$id}',lng='{$lng}',val='{$s}'");
        //Cache::delete($id.'_'.$lng);
      }
      die(json_encode(array('reload' => 1)));
    }
    echo 'ok';
  }

  public function upload() {

    #TODO: vstavitj upload kartinok s tezgsm.com
  }
}