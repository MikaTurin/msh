<?php
abstract class Msh_Logger_Handler_Base {

  /**
   * @var int minimum logging level at which this handler will be triggered
   */
  protected $level;

  /**
   * @var bool True means that this handler allows bubbling
               False means that bubbling is not permitted
   */
  protected $bubbling;

  /**
   * @var Msh_Logger_Formatter_Base
   */
  protected $formatter;


  public function __construct($level = Msh_Logger::DEBUG, $bubble = true, Msh_Logger_Formatter_Base $formatter = null) {
    $this->level = $level;
    $this->bubbling = $bubble;
    if ($formatter) $this->formatter = $formatter;
  }


  public function isHandling(array $record) {
    return $record['level'] >= $this->level;
  }

  public function handle(array $record) {

    if ($record['level'] < $this->level) return false;

    $this->write($record);
    return false === $this->bubbling;
  }

  public function handleBatch(array $records) {
    foreach ($records as $record) {
      $this->handle($record);
    }
  }

  abstract protected function write(array $record);

  public function close() {}


  public function setLevel($level) {
    $this->level = $level;
  }


  public function getLevel() {
    return $this->level;
  }

  public function setBubbling($bubbling) {
    $this->bubbling = $bubbling;
  }

  public function getBubbling() {
    return $this->bubbling;
  }

  public function setFormatter(Msh_Logger_Formatter_Base $formatter) {

    $this->formatter = $formatter;
  }

  public function getFormatter() {

    if (!$this->formatter) return new Msh_Logger_Formatter_Line();
    return $this->formatter;
  }

  public function __destruct() {

    $this->close();
  }

}