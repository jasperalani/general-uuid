<?php

namespace GeneralUUID\src;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class Main extends API
{

    /**
     * Main constructor.
     *
     * @param $database
     */
    public function __construct($database)
    {
        parent::__construct($database);

        $app = API::$API->createApp();

        $this->routes($app);

        $app->run();
    }

    /**
     * Define the routes
     *
     * @param App $app
     */
    public function routes(App $app)
    {
        $app->post('/', function (Request $request, Response $response) {
            $requirements = json_decode($request->getBody()->getContents());
            $requirements = new Requirements($requirements);

            $UUID = new UUID($requirements);

            $response->getBody()->write($UUID->response->getResponse());

            return $response->withHeader(
                'Content-Type',
                'application/json'
            )->withStatus($UUID->response->getCode());
        });
    }

}