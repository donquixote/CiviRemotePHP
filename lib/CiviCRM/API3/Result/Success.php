<?php

namespace CiviCRM\API3\Result;

class Success extends AbstractResult implements \ArrayAccess {

  protected $values = array();
  protected $firstValue;

  function __construct($result) {
    parent::__construct($result);
    if (isset($this->result->values) && is_array($this->result->values)) {
      $this->values = $this->result->values;
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
}
