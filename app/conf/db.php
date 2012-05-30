<?php
class Sql extends Msh_Sql_Mysqli {

  static protected $params;

  static protected $connected = false;
  static protected $handle;
  static protected $res;
}

Sql::initialize('localhost', 'msh', '58GB34Cxi57fv_2Q930053788E256Y', 'msh');
//Sql::$save_history = 1; //TODO: remove on production