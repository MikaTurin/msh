<?php
class Msh_Controller_Design extends Msh_Controller {

  static protected function html($css = '') {

    return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
      <html>
      <head>
        <title>CTG DEMO</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="/script/demo.css" type="text/css">
      </head>
      <body>
        <div class="rel" align="center">
        <div class="rel boxDEMO" align="center" style="'.$css.'">
          <div class="rel page" align="left"></div>
        </div>
        </div>
      </body>
      </html>';
  }

  static public function index() {

    echo static::html('background:url(/design2/pic_home.png) no-repeat center -169px;');
  }

  static public function inner() {

    echo static::html('background:url(/design2/pic_company.png) no-repeat center -169px;');
  }
}