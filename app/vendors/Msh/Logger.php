<?php
class Msh_Logger {

  /**
   * Detailed debug information
   */
  const DEBUG = 100;

  /**
   * Interesting events
   */
  const INFO = 200;

  /**
   * Exceptional occurrences that are not errors
   * Examples: Use of deprecated APIs, poor use of an API,
   * undesirable things that are not necessarily wrong.
   */
  const WARNING = 300;

  /**
   * Runtime errors
   */
  const ERROR = 400;

  /**
   * Critical conditions
   * Example: Application component unavailable, unexpected exception.
   */
  const CRITICAL = 500;

  /**
   * Action must be taken immediately
   * Example: Entire website down, database unavailable, etc.
   * This should trigger the SMS alerts and wake you up.
   */
  const ALERT = 550;

  protected static $levels = array(
    100 => 'DEBUG',
    200 => 'INFO',
    300 => 'WARNING',
    400 => 'ERROR',
    500 => 'CRITICAL',
    550 => 'ALERT',
  );

  static private $instances = array();

  protected $name;

  /**
   * The handler stack
   * @var array of Msh_Logger_Handler_Base
   */
  protected $handlers = array();


  private function __construct() {}

  /**
   * @static
   * @param $name
   * @return Msh_Logger
   */
  static public function instance($name) {

    if (!isset(static::$instances[$name])) {
      static::$instances[$name] = new self();
      static::$instances[$name]->name = $name;
    }
    return static::$instances[$name];
  }

  public function getName() {

    return $this->name;
  }

  /**
   * Pushes a handler on to the stack.
   * @param Msh_Logger_Handler_Base $handler
   */
  public function addHandler(Msh_Logger_Handler_Base $handler) {
    array_unshift($this->handlers, $handler);
  }

  /**
   * Adds a log record.
   *
   * @param integer $level The logging level
   * @param string $message The log message
   * @param array $extra The log context
   * @return Boolean Whether the record has been processed
   */
  public function addRecord($level, $message, array $extra = array()) {

    if (!$this->handlers) $this->addHandler(new Msh_Logger_Handler_Stream('php://stdout'));

    $record = array(
      'message'    => $message,
      'level'      => $level,
      'level_name' => static::getLevelName($level),
      'channel'    => $this->name,
      'datetime'   => new DateTime(),
      'extra'      => $extra
    );
    // check if any message will handle this message
    $handlerKey = null;

    foreach ($this->handlers as $key => /* @var $handler Msh_Logger_Handler_Base */ $handler) {
      if ($handler->isHandling($record)) {
        $handlerKey = $key;
        break;
      }
    }

    if (null === $handlerKey) return false; // none found

    while (isset($this->handlers[$handlerKey]) && true === $this->handlers[$handlerKey]->handle($record)) {
      $handlerKey++;
    }

    return true;
  }

  public static function getLevelName($level) {

    return self::$levels[$level];
  }

  public function debug($message, array $extra = array()) {

    return $this->addRecord(self::DEBUG, $message, $extra);
  }

  public function info($message, array $extra = array()) {

    return $this->addRecord(self::INFO, $message, $extra);
  }

  public function warn($message, array $extra = array()) {

    return $this->addRecord(self::WARNING, $message, $extra);
  }

  public function error($message, array $extra = array()) {
    return $this->addRecord(self::ERROR, $message, $extra);
  }

  public function critical($message, array $extra = array()) {

    return $this->addRecord(self::CRITICAL, $message, $extra);
  }

  public function alert($message, array $extra = array()) {

    return $this->addRecord(self::ALERT, $message, $extra);
  }

  /**
   * Checks whether the Logger has a handler that listens on the given level
   *
   * @param integer $level
   * @return Boolean
   */
  public function isHandling($level) {
    $record = array(
      'message' => '',
      'context' => array(),
      'level' => $level,
      'level_name' => self::getLevelName($level),
      'channel' => $this->name,
      'datetime' => new DateTime(),
      'extra' => array(),
    );

    foreach ($this->handlers as /* @var $handler Msh_Logger_Handler_Base */ $handler) {
      if ($handler->isHandling($record)) {
        return true;
      }
    }

    return false;
  }
}