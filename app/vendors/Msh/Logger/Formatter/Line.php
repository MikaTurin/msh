<?php
class Msh_Logger_Formatter_Line extends Msh_Logger_Formatter_Base {

  protected $format = "[%datetime%] %channel%.%level_name%: %message% %extra%\n";


  public function __construct($format = null, $dateFormat = null) {

    if ($format) $this->format = $format;
    parent::__construct($dateFormat);
  }

  public function format(array $record) {

    $output = $this->format;

    if ((is_array($record['extra']) && sizeof($record['extra'])) || $record['extra'] instanceof \Traversable) {

      foreach ($record['extra'] as $var => $val) {
        if (false !== strpos($output, '%extra.' . $var . '%')) {
          $output = str_replace('%extra.' . $var . '%', $this->convertToString($val), $output);
          unset($record['extra'][$var]);
        }
      }
      if (is_array($record['extra']) && !sizeof($record['extra'])) $record['extra'] = '';
    }
    else $record['extra'] = '';

    foreach ($record as $var => $val) {
      $output = str_replace('%' . $var . '%', $this->convertToString($val), $output);
    }

    return $output;
  }

  public function formatBatch(array $records) {

    $message = '';
    foreach ($records as $record) $message .= $this->format($record);
    return $message;
  }

  protected function normalize($data) {

    if (is_bool($data) || is_null($data)) return var_export($data, true);
    return parent::normalize($data);
  }

  protected function convertToString($data) {

    if (is_scalar($data) || is_null($data) || $data instanceof \DateTime) return (string)$this->normalize($data);
    $data = $this->toJson($this->normalize($data));
    if (version_compare(PHP_VERSION, '5.4.0', '<')) $data = stripslashes($data);
    return $data;
  }
}