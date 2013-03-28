<?php
// Include this only if you have no other autoload solution available.

spl_autoload_register(function($class) {
  $ns = 'CiviCRM\\API3\\';
  $len = strlen($ns);
  if ($ns === substr($class, 0, $len)) {
    $suffix = substr($class, $len);
    if (FALSE !== $nspos = strrpos($suffix, '\\')) {
      $namespace = substr($suffix, 0, $nspos);
      $classname = substr($suffix, $nspos + 1);
      $path = 'lib/CiviCRM/API3/' . str_replace('\\', '/', $namespace) . '/' . str_replace('_', '/', $classname) . '.php';
    }
    else {
      $classname = $suffix;
      $path = 'lib/CiviCRM/API3/' . str_replace('_', '/', $classname) . '.php';
    }
    if (is_file($path)) {
      include $path;
    }
  }
});
