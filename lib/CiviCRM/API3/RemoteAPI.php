<?php

namespace CiviCRM\API3;

class RemoteAPI extends AbstractAPI {

  protected $uri;
  protected $siteKey;
  protected $apiKey;

  /**
   * @param array $config
   *   Configuration..
   */
  function __construct($config) {

    // Validate
    if (empty($config['server'])) {
      throw new \Exception("Must specify server in config.");
    }
    if (empty($config['site_key'])) {
      throw new \Exception("Must specify 'site_key' (CIVICRM_SITE_KEY from your civicrm.settings.php).");
    }
    if (empty($config['api_key'])) {
      throw new \Exception("Must specify 'api_key' (api_key from a CiviCRM contact record).");
    }

    // Fall back to defaults
    if (empty($config['path'])) {
      $config['path'] = '/sites/all/modules/civicrm/extern/rest.php';
    }
    elseif ('/' !== $config['path']{0}) {
      $config['path'] = '/' . $config['path'];
    }

    // Set protected properties
    $this->uri = $config['server'] . $config['path'] . '?json=1';
    $this->siteKey = $config['site_key'];
    $this->apiKey = $config['api_key'];
  }

  /**
   * Wrap the result into an object.
   */
  protected function wrapResult($result, $entity, $action, $params) {
    if (empty($result)) {
      throw new \Exception("Remote API fail on $entity.$action.");
    }
    return parent::wrapResult($result, $entity, $action, $params);
  }

  /**
   * Perform the remote REST call.
   */
  protected function apiCall($entity, $action, $params) {

    // We leave 'entity' and 'action' in the url for easier debugging.
    // For the rest we will try to use POST.
    $uri = $this->uri . "&entity=$entity&action=$action";

    $params['key'] = $this->siteKey;
    $params['api_key'] = $this->apiKey;
    $fields = array();
    foreach ($params as $k => $v) {
      $fields[] = "$k=" . urlencode($v);
    }
    $fields = implode('&', $fields);

    if (function_exists('curl_init')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $uri);
      curl_setopt($ch, CURLOPT_POST, count($params));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

      // Execute post
      $result = curl_exec($ch);
      curl_close($ch);
    }
    else {
      // Not good, all in get when should be in post.
      $result = file_get_contents($uri . '&' . $fields);
    }

    return json_decode($result);
  }
}
