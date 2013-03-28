<?php

namespace CiviCRM\API3;

class EntityAPI {

  protected $api;
  protected $entity;

  function __construct($api, $entity) {
    $this->api = $api;
    $this->entity = $entity;
  }

  function __call($action, $args) {
    if (1 !== count($args)) {
      throw new \Exception('Must be exactly one arg.');
    }
    $params = $args[0];
    return $this->api->call($this->entity, $action, $params);
  }
}
