<?php
class Msh_Session {

  static function start($session_id = null) {

    #IMPORTANT lighttpd cant see this variable change, have to put it in php.ini file
    ini_set('session.gc_maxlifetime', 28800);
    session_set_cookie_params(0, '/');

    if (!empty($session_id) && preg_match('/^[a-z0-9]{20,32}$/iU', $session_id)) {
      //dump('setting new session id: '.$session_id);
      session_id($session_id);
    }

    session_start();

    if (!isset($_SESSION['SESS_HASH'])) {

      $_SESSION['SESS_HASH'] = self::salt();
    }
    elseif ($_SESSION['SESS_HASH'] != self::salt()) { //someone trying to hijack session

/*      $f = fopen(APP.'cache/tmp/'.time(), 'w');
      $e = "\n";
      fwrite($f, $_SESSION['SESS_HASH'].$e.self::salt().$e.$_SERVER['REMOTE_ADDR'].$e.$_SERVER['HTTP_USER_AGENT']);
      fclose($f);*/
      session_destroy();
      unset($_SESSION);
      session_start();
      $_SESSION['SESS_HASH'] = self::salt();
    }
  }

  static function destroy() {

    session_destroy();
  }

  static function getIpForSalt() {

    $ip = explode('.', str_replace('::ffff:', '', $_SERVER['REMOTE_ADDR']));
    unset($ip[3]);
    //unset($ip[2], $ip[3]);
    return implode('|', $ip);
  }

  static function salt() {

    //Removing chromeframe data cause shifty behaviour
    //$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727) chromeframe/6.0.472.63';
    $s = preg_replace('/chromeframe\/[0-9.]+/is', '', $_SERVER['HTTP_USER_AGENT']);
    $s = static::getIpForSalt().$s;
    $c = array('/', '.', '(', ';', ')', '-', ',', ' ', ':');
    $s = str_replace($c, '', $s);

    return $s;
  }
}
