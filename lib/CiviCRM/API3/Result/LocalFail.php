<?php

namespace CiviCRM\API3\Result;

class LocalFail {

  protected $api;

  function __construct($api) {
    $this->api = $api;
  }

  function is_error() {
    return TRUE;
  }
}
