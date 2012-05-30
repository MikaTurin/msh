<?php
/**
 * Msh_View_Smarty
 *
 * The Msh_View_Smarty is a custom View class that renders templates using the Smarty
 * template language (http://www.smarty.net).
 *
 * @package Msh
 * @author  mika.turin
 */
class Msh_View_Smarty extends Slim_View {

  /**
   * @var Smarty persistent instance of the Smarty object
   */
  private static $smarty = null;


  /**
   * Render Smarty Template
   *
   * This method will output the rendered template content
   *
   * @param    string $template The path to the Smarty template, relative to the  templates directory.
   * @return   void
   */

  public function render($template) {
    $instance = self::smarty();
    $instance->assign($this->data);
    return $instance->fetch($template);
  }

  public function assign($tpl_var, $value = null, $nocache = false) {

    static::smarty()->assign($tpl_var, $value, $nocache);
  }

  public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {

    static::smarty()->display($template, $cache_id, $compile_id, $parent);
  }

  /**
   * Creates new Smarty object instance if it doesn't already exist, and returns it.
   *
   * @throws RuntimeException If Smarty lib directory does not exist
   * @return Smarty Instance
   */
  public static function smarty() {

    if (!(self::$smarty instanceof Smarty)) {

      $smarty = new Smarty();
      require_once MSH_DIR.'/conf/smarty.php';
      self::$smarty = $smarty;
    }
    return self::$smarty;
  }
}