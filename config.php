<?php

/* Basic settings */

// Display all errors
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Database
define('DB_NAME', 'tfk');

// Paths
define('ROOT_PATH', '/srv/ws/import/');

/* Application spesific settings */
// Visma base settings
define('VISMA_BASE_URL', 'http://tfk-fh-uqweb01.login.top.no:8110/hrm_ws');
//define('VISMA_USERNAME', 'username');
//define('VISMA_PASSWORD', '******');

// Visma recruitments
define('VISMA_RECRUITMENTS', true); // Activate Visma recruitment import
define('RECRUITMENTS_PATH', ROOT_PATH . 'recruitments');
define('RECRUITMENTS_SCRIPT', 'import_recruitments.php');
define('RECRUITMENTS_COLLECTION', 'recruitments');

// Visma companies and employees
define('VISMA_EMPLOYEES', false); // Activate Visma companies and employees import
define('EMPLOYEES_PATH', ROOT_PATH . 'employees');
define('EMPLOYEES_SCRIPT', 'import_employees.php');
$VISMA_COMPANIES = array(1, 54, 60); // Companies to import

?>
