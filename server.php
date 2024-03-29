<?php
/* بسم الله الرحمن الرحیم */
/**
 * phpFramework
 *
 * @author     Ahmad Khaliq
 * @author     Mojtaba Zadegi
 * @copyright  2022 Ahmad Khaliq
 * @license    https://github.com/AhmadKhaliqIT/phpFramework/blob/main/LICENSE
 * @link       https://github.com/AhmadKhaliqIT/phpFramework/
 */

if (!defined('FRAMEWORK_START')) {
    die('You should not be here :)');
}

date_default_timezone_set("Asia/Tehran");
require __DIR__ . '/vendor/autoload.php';

use Core\Core;
use Core\WhoopsErrorLogger\WhoopsErrorLogger;

/* Starting Error Handler */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new WhoopsErrorLogger);
$whoops->register();

/* Load Support */
require_once BASE_PATH . '/core/Support/Helpers.php';
include_dir(BASE_PATH.'/core/Support/Contract/');
$__Core = new Core;

/* Database Connection */
$_connection = null;
if(config('Database.ConnectAutomatically',false))
{

    /* activate reporting */
    $driver = new mysqli_driver();
    $driver->report_mode = MYSQLI_REPORT_OFF;

    try {
        $_connection = new mysqli(
            config('Database.servername'),
            config('Database.username'),
            config('Database.password'),
            config('Database.dbname'));
        $_connection -> set_charset("utf8");
        $_connection->query('SET SESSION sql_mode = ``;');


    }
    catch (\Exception){die("Database connection failed");}
}





/* Load All Routes */
include_dir(BASE_PATH . '/routes/');

Core()->RouterBase()->run();
//Core()->getInstanceOf('RouterBase')->run();
