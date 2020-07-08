<?php

namespace GeneralUUID\src;

use stdClass;

class Requirements {

    public string $type;
    public int $length;
    public bool $save;

    /**
     * Requirements constructor.
     *
     * @param stdClass $requirements
     */
    public function __construct(stdClass $requirements)
    {
        $this->type = isset($requirements->type) ? $requirements->type : 'nosave';
        $this->length = isset($requirements->length) ? $requirements->length : '39';
        $this->save = isset($requirements->save) ? $requirements->save : false;

        if($this->length > 255){
            $this->length = 255;
        }
    }

}