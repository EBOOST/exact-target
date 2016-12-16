<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_SendDefinitionList extends BaseModel
{
    public $FilterDefinition; // ExactTarget_FilterDefinition
    public $IsTestObject; // boolean
    public $SalesForceObjectID; // string
    public $Name; // string
    public $Parameters; // ExactTarget_Parameters
}
