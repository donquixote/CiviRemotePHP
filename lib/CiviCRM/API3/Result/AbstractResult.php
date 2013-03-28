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

  function result() {
    return $this->result;
  }

  function is_set($name) {
    return (isset($this->result->$name));
  }

  function is_error() {
    return !empty($this->result->is_error);
  }

  function __toString() {
    return json_encode($this->result);
  }
}
