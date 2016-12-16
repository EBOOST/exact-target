<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_DataExtension extends BaseModel
{
    public $Name; // string
    public $Description; // string
    public $IsSendable; // boolean
    public $IsTestable; // boolean
    public $SendableDataExtensionField; // ExactTarget_DataExtensionField
    public $SendableSubscriberField; // ExactTarget_Attribute
    public $Template; // ExactTarget_DataExtensionTemplate
    public $DataRetentionPeriodLength; // int
    public $DataRetentionPeriodUnitOfMeasure; // int
    public $RowBasedRetention; // boolean
    public $ResetRetentionPeriodOnImport; // boolean
    public $DeleteAtEndOfRetentionPeriod; // boolean
    public $RetainUntil; // string
    public $Fields; // ExactTarget_Fields
    public $DataRetentionPeriod; // ExactTarget_DateTimeUnitOfMeasure
    public $CategoryID; // long
    public $Status; // string
}
