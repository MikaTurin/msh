<?php
class Msh_Admin {

  static public function in() {

    return isset($_SESSION['isadmin']);
  }

  static public function login($usr, $pwd) {

    if ($usr == 'admin' && $pwd == 'admin') {
      $_SESSION['isadmin'] = $usr;
      static::editorShow();
      return true;
    }
    return false;
  }

  static public function logout() {

    unset($_SESSION['isadmin']);
    static::editorHide();
  }

  static public function editorShow() {

    $_SESSION['showeditor'] = 1;
  }

  static public function editorHide() {

    unset($_SESSION['showeditor']);
  }

  static public function isEditor() {

    return isset($_SESSION['showeditor']);
  }
}