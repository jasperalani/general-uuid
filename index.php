<?php

/*

 Install:
 $ composer require slim/slim:"4.*" slim/psr7

 */

use GeneralUUID\src\Main;

include_once 'src/Includes.php';

$_ENV = 'dev'; // 'live'

$database_information = [
    'host'     => '127.0.0.1',
    'username' => 'root',
    'password' => 'password',
    'database' => '',
    'port'     => '3306'
];

new Main($database_information);