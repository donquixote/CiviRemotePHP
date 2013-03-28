<?php

namespace CiviCRM\API3;

class Result implements \ArrayAccess {

  protected $result;
  protected $values = array();
  protected $firstValue;

  function __construct($result) {
    if (is_array($result)) {
      $result = (object)$result;
    }
    $this->result = $result;
    if (isset($result->values) && is_array($result->values)) {
      $this->values = $result->values;
      foreach ($this->values as $value) {
        $this->firstValue = $value;
        break;
      }
    }
  }

  // Data access
  // ---------------------------------------------------------------------------

  /**
   * Get all values
   */
  function values() {
    return $this->values;
  }

  /**
   * Get the first value
   */
  function firstValue() {
    return $this->firstValue;
  }

  /**
   * Get an attribute from the first result.
   */
  function __get($key) {
    if (!empty($this->firstValue->$key)) {
      return $this->firstValue->$key;
    }
  }

  // ArrayAccess (values)
  // ---------------------------------------------------------------------------

  /**
   * Get a value with the given index.
   */
  function offsetGet($index) {
    if (isset($this->values[$index])) {
      return $this->values[$index];
    }
  }

  /**
   * Check if there is a value with the given index.
   */
  function offsetExists($index) {
    return isset($this->values[$index]);
  }

  function offsetSet($index, $value) {
    throw new \Exception("This is read-only.");
  }

  function offsetUnset($index) {
    throw new \Exception("This is read-only.");
  }

  // Result meta
  // ---------------------------------------------------------------------------

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
