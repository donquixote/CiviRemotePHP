CiviCRM API3 Wrapper: Local/Remote
=================================

This is a rewrite / clean-up of the civicrm_api3 class shipped with CiviCRM.
Might be included in the core one day.


Usage: Remote
================

Use case:
You have one server A with CiviCRM, and a server B with some random PHP (but no civi).
You want to access CiviCRM data from B.

Solution:
- Download this package into your custom PHP project.
- Usage as in example.php



Usage: Local
===============

Use case:
You have a regular CiviCRM install.
You are not happy with class civicrm_api3.

Solution:
- Download this package somewhere into your project.
- Set up autoload:
  Either include the autoload.php, as suggested in example.php
  Or use e.g. http://drupal.org/project/xautoload and register the namespace.
- Create a CiviCRM\API3\LocalAPI(..)
- Usage same as the RemoteAPI, see example.php
