<?php

namespace CiviCRM\API3;

abstract class AbstractAPI {

  protected $entityAPIs = array();

  /**
   * Get entity-specific API object
   */
  function __get($entity) {
    if (!isset($this->entityAPIs[$entity])) {
      $this->entityAPIs[$entity] = new EntityAPI($this, $entity);
    }
    return $this->entityAPIs[$entity];
  }

  /**
   * Make the API call.
   */
  function call($entity, $action = 'Get', $params = array()) {

    $params = $this->normalizeParams($params);

    $result = $this->apiCall($entity, $action, $params);

    return $this->wrapResult($result, $entity, $action, $params);
  }

  /**
   * Result object in case that we return nothing.
   */
  protected function wrapResult($result, $entity, $action, $params) {
    if (empty($result) || !is_object($result)) {
      // Every implementation (local, remote)
      // has a different type of error if the result is empty.
      throw new Exception("Result is empty.");
    }
    elseif (!empty($result->is_error)) {
      throw new Exception("Result has an error.");
    }
    else {
      return new Result($result);
    }
  }

  /**
   * Perform the actual API call.
   */
  abstract protected function apiCall($entity, $action, $params);

  /**
   * Normalize params into the correct array format, if they are not.
   */
  protected function normalizeParams($params) {

    if (is_int($params)) {
      $params = array('id' => $params);
    }
    elseif (is_string($params)) {
      $params = json_decode($params);
    }

    if (empty($params['version']) || !is_numeric($params['version'])) {
      $params['version'] = 3;
    }

    if (!isset($params['sequential']) || !is_numeric($params['sequential'])) {
      $params['sequential'] = 1;
    }

    return $params;
  }
}
