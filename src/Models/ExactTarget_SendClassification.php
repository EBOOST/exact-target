<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_SendClassification extends BaseModel
{
    public $SendClassificationType; // ExactTarget_SendClassificationTypeEnum
    public $Name; // string
    public $Description; // string
    public $SenderProfile; // ExactTarget_SenderProfile
    public $DeliveryProfile; // ExactTarget_DeliveryProfile
    public $HonorPublicationListOptOutsForTransactionalSends; // boolean
    public $SendPriority; // ExactTarget_SendPriorityEnum
    public $ArchiveEmail; // boolean
}
