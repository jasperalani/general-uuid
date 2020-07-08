<?php

namespace GeneralUUID\src;

use Slim\App;
use Slim\Factory\AppFactory;
use mysqli;

class API
{

    public static mysqli $database;
    public static API $API;

    /**
     * API constructor.
     *
     * @param $database
     */
    public function __construct($database)
    {
        API::$database = $this->retrieveDatabase($database);
        API::$API      = $this;
    }

    /**
     * Create app
     *
     * @return App
     */
    public function createApp(): App
    {
        $app = AppFactory::create();

        $this->registerErrors($app);

        return $app;
    }

    /**
     * Register error rendering
     *
     * @param App $app
     */
    private function registerErrors(App $app)
    {
        switch ($_ENV) {
            case 'dev':
                $error = [true, true, true];
                break;
            default:
                $error = [false, false, false];
                break;
        }
        $errorMiddleware = $app->addErrorMiddleware($error[0], $error[1], $error[2]);
        $errorHandler    = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->registerErrorRenderer('text/html', Error::class);
    }


    /**
     * Retrieve a database object
     *
     * @param $database
     *
     * @return mysqli
     */
    function retrieveDatabase($database): mysqli
    {
        $mysqli = new mysqli(
            $database['host'],
            $database['username'],
            $database['password'],
            $database['database'],
            $database['port']
        );

        if ($mysqli->connect_errno) {
            echo "Error: Failed to make a MySQL connection, here is why: \n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            echo "Error: " . $mysqli->connect_error . "\n";
            echo "Please report this error to your webmaster.";
            exit;
        }

        return $mysqli;
    }

}