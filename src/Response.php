<?php

namespace GeneralUUID\src;

class Response
{

    public string $response;
    public int $code;

    public int $jsonOptions;

    /**
     * Response constructor.
     *
     * @param $response
     * @param $code
     */
    public function __construct($response, $code)
    {
        $this->jsonOptions = 128 | 32;
        $this->response    = json_encode($response, $this->jsonOptions);
        $this->code        = ceil(log10($code)) !== 3 ? $code : 200;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Get response
     *
     * @return false|string
     */
    public function getResponse()
    {
        return $this->response;
    }

}