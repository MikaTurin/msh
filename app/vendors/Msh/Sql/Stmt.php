<?php
class Msh_Sql_Stmt extends Mysqli_stmt {

  protected $flds;
  /*protected $params;*/

  public function __construct($link, $query) {
    parent::__construct($link, $query);
    if($this->sqlstate != '00000') die('Incorrect prepare query statement');
  }

  public function execute() {
    if (parent::execute()) return true;
    throw new Emoney_SqlException();
  }

  public function run() {

    $this->flds = null;
    $this->execute();
    $this->store_result();
  }

  /**
   * bind params to prepared query, dont need to pass parameters by reference
   * @param string $types
   * @param mixed $var1
   */
  public function setParams($types, $var1) {

    $r = func_get_args();
    $arrParams = $this->getRefArray($r); // <-- Added due to changes since PHP 5.3
    $method = new ReflectionMethod('Msh_Sql_Stmt', 'bind_param');
    //print_r($arrParams);
    $method->invokeArgs($this, $arrParams);
  }

  public function fetchAll() {

    $r = array();
    $this->execute();
    $meta = $this->result_metadata();

    if ($meta) {

      $this->store_result();
      $params = array();
      $row = array();
      while ($field = $meta->fetch_field()) $params[] = &$row[$field->name];
      $meta->close();

      $method = new ReflectionMethod('Mysqli_stmt', 'bind_result');
      $method->invokeArgs($this, $params);

      while ($this->fetch()) {

        $a = array();
        foreach ($row as $key => $val) $a[$key] = $val;
        $r[] = $a;
      }
      $this->free_result();
    }
    return $r;
  }

  protected function getFields() {

    $meta = $this->result_metadata();
    if ($meta) {

      $this->store_result();
      $params = array();
      $this->flds = array();
      while ($field = $meta->fetch_field()) $params[] = &$this->flds[$field->name];
      $meta->close();

      $method = new ReflectionMethod('Mysqli_stmt', 'bind_result');
      $method->invokeArgs($this, $params);
    }
  }

  public function fetchAssoc() {

    if (!is_array($this->flds)) $this->getFields();
    $a = array();

    if ($this->fetch()) {
      //var_dump($this->flds);
      //echo '<hr>';
      foreach ($this->flds as $key => $val) $a[$key] = $val;
    }
    return $a;
  }

  public function numRows() {

    return $this->num_rows;
  }

  protected function getRefArray($a) {

    if (strnatcmp(phpversion(), '5.3') >= 0) {
      $r = array();
      foreach ($a as $k => $v) $r[$k] = &$a[$k];
      return $r;
    }

    return $a;
  }

}