<?php
// Include this only if you have no other autoload solution available.
namespace CiviCRM\API3;

_init_autoload();

function _init_autoload() {
  $dir = dirname(__FILE__) . '/lib/CiviCRM/API3/';

  spl_autoload_register(function($class) use ($dir) {
    $ns = 'CiviCRM\\API3\\';
    $len = strlen($ns);
    if ($ns === substr($class, 0, $len)) {
      $suffix = substr($class, $len);
      if (FALSE !== $nspos = strrpos($suffix, '\\')) {
        $namespace = substr($suffix, 0, $nspos);
        $classname = substr($suffix, $nspos + 1);
        $path = $dir . str_replace('\\', '/', $namespace) . '/' . str_replace('_', '/', $classname) . '.php';
      }
      else {
        $classname = $suffix;
        $path = $dir . str_replace('_', '/', $classname) . '.php';
      }
      if (is_file($path)) {
        include $path;
      }
    }
  });
}
