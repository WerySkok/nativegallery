<?php
// Prevent worker script termination when a client connection is interrupted
ignore_user_abort(true);
echo 'gfdfgdfgdgfdgf';
require __DIR__.'/vendor/autoload.php';

// Include the App class definition
use App\Core\{Routes, Page};
use App\Services\DB;
use Symfony\Component\Yaml\Yaml;
use Tracy\Debugger;

class App
{
    public static function start()
    {
        error_reporting(E_ALL & ~E_WARNING);

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/ngallery.yaml')) {
            define("NGALLERY", Yaml::parse(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/ngallery.yaml'))['ngallery']);
            if (NGALLERY['root']['debug'] === true) {
                Debugger::enable();
            }
            try {
                if (NGALLERY['root']['maintenance'] === false) {
                    DB::connect();
                    Routes::init();
                } else {
                    Page::set('Errors/ServerDown');
                }
            } catch (PDOException $ex) {
                echo $ex;
                Page::set('Errors/DB_42000');
            } catch (Exception $ex) {
                echo $ex;
                Page::set('Errors/DB_42000');
            }
        } else {
            Page::set('Errors/Problems');
        }
    }
}

App::start();
