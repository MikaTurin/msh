<?php
class Msh_Logger_Handler_Stream extends Msh_Logger_Handler_Base {

  /**
   * @var resource
   */
  protected $stream;

  /**
   * @var string
   */
  protected $url;

  /**
   * @var int Seconds before class gives up trying to lock resource
   */
  protected $timeout = 5;

  /**
   * use file locking
   * @var bool
   */
  protected $useLock = true;


  public function __construct($stream, $level = Msh_Logger::DEBUG, $bubble = true, $use_lock = true) {

    parent::__construct($level, $bubble);
    if (is_resource($stream)) {
        $this->stream = $stream;
    } else {
        $this->url = $stream;
    }
    $this->useLock = $use_lock;
  }

  public function close() {

    if (is_resource($this->stream)) fclose($this->stream);
    $this->stream = null;
  }

  protected function write(array $record) {

    if (null === $this->stream) {
      if (!$this->url) {
         throw new LogicException('Missing stream url, the stream can not be opened. This may be caused by a premature call to close().');
      }
      $this->stream = fopen($this->url, 'a');
      if (!is_resource($this->stream)) {
         $this->stream = null;
         throw new UnexpectedValueException(sprintf('The stream or file "%s" could not be opened; it may be invalid or not writable.', $this->url));
      }
    }

    if ($this->useLock && !$this->ready()) throw new Exception('Unable to gain exclusive access to log file');
    fwrite($this->stream, (string)$this->getFormatter()->format($record));
    if ($this->useLock) flock($this->stream, LOCK_UN);
  }

  protected function ready() {

 		$time = microtime(true);
 		while (!flock($this->stream, LOCK_EX | LOCK_NB)) {
 			if ((microtime(true) - $time) > $this->timeout) return false; // Give up
 			usleep(mt_rand(0,50));
 		}
 		return true;
 	}
}