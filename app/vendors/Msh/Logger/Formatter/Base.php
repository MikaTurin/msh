<?php
class Msh_Logger_Formatter_Base {

  protected $dateFormat = 'Y-m-d H:i:s';

  public function __construct($dateFormat = null) {

    if ($dateFormat) $this->dateFormat = $dateFormat;
  }

  public function setDateFormat($dateFormat) {

    $this->dateFormat = $dateFormat;
  }

  public function format(array $record) {

    return $this->normalize($record);
  }

  public function formatBatch(array $records) {

    foreach ($records as $key => $record) $records[$key] = $this->format($record);
    return $records;
  }

  protected function normalize($data) {

    if (is_null($data) || is_scalar($data)) return $data;

    if ($data instanceof \DateTime) return $data->format($this->dateFormat);

    if (is_array($data) || $data instanceof \Traversable) {

      $normalized = array();
      foreach ($data as $key => $value) $normalized[$key] = static::normalize($value);
      return $normalized;
    }

    if (is_resource($data)) return '[resource]';

    return sprintf("[object] (%s: %s)", get_class($data), $this->toJson($data));
  }

  protected function toJson($data) {

    if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
      return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    return json_encode($data);
  }
}