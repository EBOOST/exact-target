<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_CreateRequest extends BaseModel
{
    public $Options; // ExactTarget_CreateOptions
    public $Objects; // ExactTarget_APIObject
}
