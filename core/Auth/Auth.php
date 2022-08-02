<?php
namespace Core\Auth;
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



use Core\Router\RouterBase;
use Exception;

class Auth{

    private static array $Guards=[];
    public  static string $_current_middleware_guard;
    private static array $_config_guards_tables=[];

    public static function init()
    {
        $config_g = config('Auth.guards');
        foreach ($config_g as $config)
        {
            self::$_config_guards_tables[$config['name']] = $config['table'];
        }
    }


    public static function user(): object
    {
        if (!array_key_exists(self::$_current_middleware_guard,self::$Guards))
            die('Error: Guard is not defined!');

        return self::$Guards[self::$_current_middleware_guard]->user();
    }


    public static function guard($guard): object
    {
        if (empty(self::$_config_guards_tables))
            self::init();

        if (!array_key_exists($guard,self::$_config_guards_tables))
            die('Error: Guard '.$guard . ' does not exist!');

        if (!array_key_exists($guard,self::$Guards))
            self::$Guards[$guard] = new Guard($guard,self::$_config_guards_tables[$guard]);

        return self::$Guards[$guard];
    }
}