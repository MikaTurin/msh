<?php
class Msh_Sql_MySql {

  static protected $params;

  static public $connected = false;
  static public $handle;
  static public $res;

  static public $history = array();
  static public $save_history = 0;
  static public $driver = 'mysql';

  static function initialize($server, $login, $password, $db, $port = 3306) {

    static::$params = array();
    static::$params['server'] = $server;
    static::$params['login'] = $login;
    static::$params['passwd'] = $password;
    static::$params['dbname'] = $db;
    static::$params['port'] = $port;
  }

  static function connect() {

    if (static::$connected === true) return;
    if (!is_array(static::$params)) die('MySql no initialization');
    if (self::$save_history) $b = microtime(true);

    static::$handle = mysql_connect(
      static::$params['server'],
      static::$params['login'],
      static::$params['passwd']
    ) or die('Mysql ' . get_called_class() . ' connection failed!');

    if (self::$save_history)
      self::$history[] = number_format(microtime(true) - $b, 8) . ': ' . get_called_class() . ' connect';

    static::$connected = true;
    self::selectDb(static::$params['dbname']);
    mysql_set_charset('utf8', static::$handle);
  }

  static function selectDb($db) {

    if (!static::$connected) return false;
    return mysql_select_db($db, static::$handle);
  }

  static function query($q) {

    self::connect();
    if (self::$save_history) $b = microtime(true);

    static::$res = mysql_query($q, static::$handle) or
      die('SQL ERROR' .(self::$save_history ? ': '.dump($q, true) . '<br>' . mysql_errno(static::$handle) . ' ' . mysql_error(static::$handle) : ''));

    if (self::$save_history)
      self::$history[] = number_format(microtime(true) - $b, 8) . ': ' . trim(preg_replace('/\s+/', ' ', $q));

    return static::$res;
  }

  static function numRows($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    if (!$handle) return false;
    return mysql_num_rows($handle);
  }

  static function lastId() {

    self::connect();
    return mysql_insert_id(static::$handle);
  }

  static function fetchAssoc($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    return mysql_fetch_assoc($handle);
  }

  static function fetchArray($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    return mysql_fetch_array($handle, MYSQL_NUM);
  }

  static function fetchField($field, $row = 0, $handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;

    mysql_data_seek($handle, $row);

    $r = self::fetchAssoc($handle);
    if (isset($r[$field])) return $r[$field];
    return null;
  }

  static function fetchAll() {

    self::connect();
    $c = self::numRows();

    $r = array();
    for ($i=0; $i<$c; $i++) $r[] = mysql_fetch_assoc(static::$res);

    return $r;
  }

  static function affectedRows($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$handle;

    return mysql_affected_rows($handle);
  }

  static function freeResult() {

    if (static::$res) return (mysql_free_result(static::$res)); else return false;
  }

  static function escapeString($s) {

    self::connect();
    return mysql_real_escape_string($s, static::$handle);
  }

  static function arrayToQuery(array $r) {

    $special = array('NOW()');
    $q = '';
    foreach ($r as $k => $v) {
      if (in_array($v, $special)) {
        $q .= '`'.$k."`=".$v.",";
      }
      else {
        $q .= '`'.$k."`='".addslashes($v)."',";
      }
    }
    return substr($q, 0, -1);
  }
}