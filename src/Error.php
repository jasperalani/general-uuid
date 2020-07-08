<?php

namespace GeneralUUID\src;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class Error implements ErrorRendererInterface
{
    /**
     * Error invoker.
     *
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     *
     * @return string
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $payload = ['error' => $exception->getMessage(), 'code' => $exception->getCode()];
        return json_encode($payload, JSON_UNESCAPED_UNICODE);
    }
}