<?php

namespace CiviCRM\API3\Result;

class AbstractResult {

  protected $result;

  function __construct($result) {
    if (is_array($result)) {
      $result = (object)$result;
    }
    $this->result = $result;
  }

  function result($key = NULL) {
    if (empty($key)) {
      return $this->result;
    }
    elseif (isset($this->result->$key)) {
      return $this->result->$key;
    }
  }

  /**
   * We can't name this isSet() cause that's a reserved word.
   */
  function is_set($name) {
    return (isset($this->result->$name));
  }

  /**
   * We could rename this as isError()
   */
  function is_error() {
    return !empty($this->result->is_error);
  }

  function __toString() {
    return json_encode($this->result);
  }
}
