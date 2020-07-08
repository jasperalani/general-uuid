<?php

namespace GeneralUUID\src;

use mysqli_result;

class UUID
{

    public Requirements $requirements;
    public Response $response;

    /**
     * UUID constructor.
     *
     * @param Requirements $requirements
     *
     */
    public function __construct($requirements)
    {
        $this->requirements = $requirements;

        $UUID = $this->generateUUID($this->requirements);

        $code = 200;

        if ($this->requirements->save) {

            $checkForType = $this->checkForType($this->requirements);

            if ( ! $checkForType) {

                $createType = $this->createType($this->requirements);
                if ( ! $createType) {
                    $this->response = new Response(["error" => "Failed to create type"], 500);
                }

            }

            $saveUUID = $this->saveUUID($this->requirements, $UUID);

            if ( ! $saveUUID ) {
                $this->response = new Response(["error" => "Failed to save uuid"], 500);
            }

            $code = 201;
        }

        $this->response = new Response(["uuid" => $UUID], $code);
    }

    /**
     * Check for an existing type column in database
     *
     * @param Requirements $requirements
     *
     * @return int
     */
    public function checkForType(Requirements $requirements)
    {
        $type = $requirements->type;

        return API::$database->query(<<<MYSQL_QUERY
                  SELECT *
                  FROM INFORMATION_SCHEMA.COLUMNS
                  WHERE TABLE_NAME = 'uuid'
                  AND COLUMN_NAME = '$type';
                  MYSQL_QUERY
        )->num_rows;
    }

    /**
     * Create type in database
     *
     * @param Requirements $requirements
     *
     * @return bool|mysqli_result
     */
    public function createType(Requirements $requirements)
    {
        $type   = $requirements->type;
        $length = $requirements->length;
        $query  = "ALTER TABLE uuid ADD $type CHAR($length);";
        API::$database->query("USE generaluuid;");

        return API::$database->query($query);
    }

    /**
     * Generate a unique id based on the requirements
     *
     * @param Requirements $requirements
     *
     * @return false|string
     */
    public function generateUUID(Requirements $requirements)
    {
        $uuid          = uniqid();
        $create_uniqid = (int)($requirements->length / strlen($uuid));

        $unique_id = $uuid;

        for ($i = 0; $i < $create_uniqid; $i++) {
            $unique_id .= uniqid();
        }

        $unique_id = substr($unique_id, 0, $requirements->length);

        return $unique_id;
    }

    /**
     * Save uuid to database column
     *
     * @param Requirements $requirements
     * @param string $UUID
     *
     * @return bool|mysqli_result
     */
    public function saveUUID(Requirements $requirements, string $UUID)
    {
        $type  = $requirements->type;
        $query = "INSERT INTO uuid ($type) VALUES ('$UUID');";
        API::$database->query("USE generaluuid;");

        return API::$database->query($query);
    }

}