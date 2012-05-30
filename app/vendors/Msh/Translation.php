<?php
class Msh_Translation {

  static $cache = array();

  static public function get($key, $lng = null) {

    if (!$lng) $lng = Msh::getInstance()->getLanguage();

    $r = static::getValsByKey($key);
    if (isset($r[$lng])) return $r[$lng];
    return NULL;
  }

  static public function getValsByKey($key) {

    static $q;

    if (isset(static::$cache[$key])) return static::$cache[$key];

    static::addKey($key); //TODO: remove on production, only for faster development

    if (!isset($q)) {
      $q = Sql::prepare("
        SELECT
          lng,
          val
        FROM
          translations
        WHERE
           id=?
      ");
    }
    $q->setParams('s', $key);
    $q->run();
    $c = $q->numRows();
    $r = array();
    $lang = Msh::getInstance()->config('languages');
    foreach ($lang as $k => $v) $r[$k] = '';

    for ($i=0; $i<$c; $i++) {

      $a = $q->fetchAssoc();
      $r[$a['lng']] = $a['val'];
    }
    static::$cache[$key] = $r;
    return $r;
  }

  static function toPhpCode($r) {

    $s = '';
    foreach ($r as $k => $v) {
      $v = str_replace("'", "\\'", $v);
      $s .= "'{$k}'=>'{$v}',";
    }
    $s = substr($s, 0, -1);
    return 'array('.$s.')';
  }

  static function addKey($key) {

    $lang = Msh::getInstance()->config('languages');

    $key = addslashes($key);
    $q = "SELECT lng FROM translations WHERE id='{$key}'";
    Sql::query($q);
    $r = Sql::fetchAll();

    $a = array();
    foreach ($r as $v) $a[$v['lng']] = 1;
    unset($r);

    foreach ($lang as $lng => $v) {

      if (!isset($a[$lng])) {

        $q = "INSERT INTO translations SET id='{$key}',lng='{$lng}'";
        Sql::query($q);
      }
    }

  }

}