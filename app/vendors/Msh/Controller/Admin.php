<?php
class Msh_Controller_Admin extends Msh_Controller {

  public function index() {

    echo 'thats admin babe!';
  }

  public function editor() {

    $mode = '';
    if (isset($_GET['mode'])) $mode = $_GET['mode'];

    if ($mode == 'off') {

      $val = 0;
      unset($_SESSION['isadmin']);
    }
    else {
      $val = 1;
      $_SESSION['isadmin'] = 1;
    }

/*    if (is_ajax()) {
      print_r($_SESSION);
      die('mode:'.$val);
    }*/

    header('Location: /');
    exit;
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