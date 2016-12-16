<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_CreateResponse extends BaseModel
{

    public $Results; // ExactTarget_CreateResult
    public $RequestID; // string
    public $OverallStatus; // string

    public function __construct($object)
    {
        $this->cast($object);
    }

    protected function cast($object)
    {
        if (is_array($object) || is_object($object)) {
            foreach ($object as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}
