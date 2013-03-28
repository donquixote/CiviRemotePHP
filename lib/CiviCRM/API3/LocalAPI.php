<?php

namespace CiviCRM\API3;

class LocalAPI extends AbstractAPI {

  protected $cfg;

  /**
   * @param array $config
   *   Configuration..
   */
  function __construct($config) {

    if (isset($config) && isset($config['conf_path'])) {
      define('CIVICRM_SETTINGS_PATH', $config['conf_path'] . '/civicrm.settings.php');
      require_once CIVICRM_SETTINGS_PATH;
      require_once 'CRM/Core/Config.php';
      require_once 'api/api.php';
      require_once "api/v3/utils.php";
      $this->cfg = CRM_Core_Config::singleton();
      CRM_Core_DAO::init($this->cfg->dsn);
    }

    $this->cfg = CRM_Core_Config::singleton();
  }

  /**
   * Helper method for long running programs (eg bots)
   *
   * TODO: Does this really belong here?
   */
  function ping() {
    global $_DB_DATAOBJECT;
    foreach ($_DB_DATAOBJECT['CONNECTIONS'] as & $c) {
      if (!$c->connection->ping()) {
        $c->connect($this->cfg->dsn);
        if (!$c->connection->ping()) {
          die("We couldn't connect to the CiviCRM database.");
        }
      }
    }
  }

  /**
   * Perform the actual API call.
   */
  protected function apiCall($entity, $action, $params) {

    $result = civicrm_api($entity, $action, $params);

    // easiest to convert a multi-dimentional array into an object
    return json_decode(json_encode($result));
  }
}
