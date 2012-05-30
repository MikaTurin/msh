<?php
class Msh extends Slim {

  //static $instance = null;
  //static $mshLoadConfig = 'app.php';

  public function __construct( $userSettings = array() ) {

    parent::__construct($userSettings);
    $this->router = new Msh_Router($this->request, $this->response);
    $this->response = new Msh_Http_Response();
  }

  /**
   * @static
   * @return null|Msh
   */
  public static function getInstance($name = null) {

    return parent::getInstance('default');
  }

  public static function getDefaultSettings() {

    return array(
      //Application
      'install_autoloader' => false,
      'mode' => 'development',
      //Debugging
      'debug' => true,
      //Logging
      'log.writer' => null,
      'log.level' => 4,
      'log.enabled' => false,
      //View
      'templates.path' => './templates',
      'view' => 'Slim_View',
      //Cookies
      'cookies.lifetime' => '20 minutes',
      'cookies.path' => '/',
      'cookies.domain' => null,
      'cookies.secure' => false,
      'cookies.httponly' => false,
      //Encryption
      'cookies.secret_key' => 'CHANGE_ME',
      'cookies.cipher' => MCRYPT_RIJNDAEL_256,
      'cookies.cipher_mode' => MCRYPT_MODE_CBC,
      //HTTP
      'http.version' => '1.1'
    );
  }

  public function setLanguage($lng) {

    $this->config('language', $lng);
  }

  public function getLanguage() {

    return $this->config('language');
  }

  public function mapController($pattern, $class) {

    return $this->router->mapController(rtrim($pattern, '/').'.*', $class)->
    //return $this->router->mapController(rtrim($pattern, '/').'\/?[^\/]*', $class)->
      via(Slim_Http_Request::METHOD_GET, Slim_Http_Request::METHOD_HEAD, Slim_Http_Request::METHOD_POST);
  }

  public function loadConfig($name) {

    require MSH_DIR.'conf/'.$name.'.php';
  }

  /**
   * Get the Response object
   * @return Msh_Http_Response
   */
  public function response() {
    return $this->response;
  }

}