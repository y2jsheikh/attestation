<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

/**
 * Hooks configuation
 * Transaction logger hook will be called after execution of each function
in application
 */
$hook['post_controller_constructor'] = array(
    'class' => 'TransactionLogger',
    'function' => 'initialize',
    'filename' => 'TransactionLogger.php',
    'filepath' => 'hooks'
);
/*
echo "<pre>";
print_r($hook);
echo "</pre>";
die;
*/
