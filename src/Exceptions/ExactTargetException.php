<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Exceptions;

use Eboost\ExactTarget\Models\ExactTarget_CreateResponse;

class ExactTargetException extends \Exception
{
    /**
     * @param ExactTarget_CreateResponse|\stdClass $result
     */
    public function __construct($result)
    {
        parent::__construct($result->OverallStatusMessage);
    }
}
