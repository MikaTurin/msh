<?php
class Msh_Sql_Mysqli {

  static protected $params;

  static protected $connected = false;
  static protected $handle;
  static protected $res;

  static public $history = array();
  static public $save_history = 0;
  static public $driver = 'mysqli';

  static public function initialize($server, $login, $password, $db, $port = 3306) {

    static::$params = array();
    static::$params['server'] = $server;
    static::$params['login'] = $login;
    static::$params['passwd'] = $password;
    static::$params['dbname'] = $db;
    static::$params['port'] = $port;
  }

  static public function connect() {

    if (static::$connected === true) return;
    if (!is_array(static::$params)) die('MySqliC no initialization');
    if (self::$save_history) $b = microtime(true);

    static::$handle = mysqli_connect(
      static::$params['server'],
      static::$params['login'],
      static::$params['passwd'],
      static::$params['dbname'],
      static::$params['port']
    ) or die('Mysql ' . get_called_class() . ' connection failed!');

    if (self::$save_history)
      self::$history[] = number_format(microtime(true) - $b, 8) . ': ' . get_called_class() . ' connect';

    mysqli_set_charset(static::$handle, 'utf8');
    static::$connected = true;
  }

  static public function selectDb($db) {

    if (!static::$connected) return false;
    return mysqli_select_db(static::$handle, $db);
  }

  static public function query($q) {

    self::connect();
    if (self::$save_history) $b = microtime(true);

    static::$res = mysqli_query(static::$handle, $q) or
      die('SQL ERROR' .(self::$save_history ? ': '.dump($q, true) . '<br>' . mysqli_errno(static::$handle) . ' ' . mysqli_error(static::$handle) : ''));

    if (self::$save_history)
      self::$history[] = number_format(microtime(true) - $b, 8) . ': ' . trim(preg_replace('/\s+/', ' ', $q));

    return static::$res;
  }

  /**
   * @static
   * @param string $q
   * @return Msh_Sql_Stmt
   * @throws Emoney_SqlException
   */
  static public function prepare($q) {

    self::connect();
    if ($stmt = new Msh_Sql_Stmt(static::$handle, $q)) return $stmt;
    throw new Emoney_SqlException();
  }

  /**
   * @static
   * @param null $handle
   * @return int
   */
  static function numRows($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    if (!$handle) return false;
    return mysqli_num_rows($handle);
  }

  static function lastId() {

    self::connect();
    return mysqli_insert_id(static::$handle);
  }

  /**
   * @static
   * @param null $handle
   * @return array
   */
  static function fetchAssoc($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    return mysqli_fetch_assoc($handle);
  }

  /**
   * @static
   * @param null $handle
   * @return array
   */
  static function fetchArray($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$res;
    return mysqli_fetch_array($handle, MYSQLI_NUM);
  }

  /**
   * @static
   * @param null $handle
   * @return array
   */
  static function fetchAll() {

    self::connect();
    $c = self::numRows();

    $r = array();
    for ($i=0; $i<$c; $i++) $r[] = mysqli_fetch_assoc(static::$res);

    return $r;
  }

  static function affectedRows($handle = null) {

    self::connect();
    if (!$handle) $handle = static::$handle;

    return mysqli_affected_rows($handle);
  }

  static function freeResult() {

    if (static::$res) return (mysqli_free_result(static::$res)); else return false;
  }

  static function escapeString($s) {

    self::connect();
    return mysqli_real_escape_string(static::$handle, $s);
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

