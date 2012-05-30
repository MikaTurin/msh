<?php
class Msh_Middleware_Languages_Standart extends Slim_Middleware {

  public function call() {

    #TODO: dopisatj redirect 301 v sluchae esli not index && not language in url
    $app = $this->app;
    $env = $app->environment();

    $lngs = $app->config('languages');
    if (!is_array($lngs)) die('Variables `languages` not set!');
    $lng = key($lngs);

    if (true) {

      $path = ltrim($env['PATH_INFO'], '/');
      if ($path) $r = explode('/', $path); else $r = array();

      if (isset($r[0]) && isset($lngs[$r[0]])) {
        $lng = array_shift($r);
      }
      elseif ($env['PATH_INFO'] == '/') {

        $url = $lng;
        if ($s = $this->detectBrowserLanguage($env, $lngs)) $url = $s;
        if (sizeof($r)) $url .= '/'.join('/', $r);
        $url = rtrim($env['SCRIPT_NAME'], '/') . '/' . $url . ($env['QUERY_STRING'] ? '?'.$env['QUERY_STRING'] : '');

        $app->response()->redirect($url, 301);
      }
      $env['PATH_INFO'] = '/'.join('/', $r);
    }
    Msh::getInstance()->setLanguage($lng);
    Msh::getInstance()->config('LURL', '/'.$lng);

    $this->next->call();
  }

  protected function detectBrowserLanguage($env, $languages) {

    if (isset($env['ACCEPT_LANGUAGE'])) {

      $supported = preg_split('/\s*,\s*/', preg_replace('/;q=[0-9.]+/', '', $env['ACCEPT_LANGUAGE']));

      foreach ($supported as $s) {

        $lang = substr(strtolower(trim($s)), 0, 2);
        if (isset($languages[$lang])) return $lang;
      }
    }
    return null;
  }
}