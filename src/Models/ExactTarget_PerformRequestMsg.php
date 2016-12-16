<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_PerformRequestMsg extends BaseModel
{
    public $Options; // ExactTarget_PerformOptions
    public $Action; // string
    public $Definitions; // ExactTarget_Definitions
}
