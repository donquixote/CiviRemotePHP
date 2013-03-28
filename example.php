<?php

// We use this only because we have no native PSR-0 autoloader in this script.
require_once 'autoload.php';

$api = new CiviCRM\API3\Remote(array(

  // Drupal root url.
  // This assumes that CiviCRM is installed in sites/all/modules/civicrm.
  'server' => 'http://civilab.localhost',

  // CIVICRM_SITE_KEY from civicrm.settings.php
  'site_key' => 'a3df105f04621f12df59a40f677458de',

  // API key from contact.
  'api_key' => 'dqx123',
));

$result = $api->Contact->Get(array(
  'id' => 202,
));

// Get value by index, using ArrayAccess magic.
var_dump($result[0]);

// Get attributes from the first value, using __get() magic.
var_dump($result->display_name);

