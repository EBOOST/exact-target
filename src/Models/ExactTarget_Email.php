<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget\Models;

class ExactTarget_Email extends BaseModel
{
    public $Name; // string
    public $Folder; // string
    public $CategoryID; // int
    public $HTMLBody; // string
    public $TextBody; // string
    public $ContentAreas; // ExactTarget_ContentArea
    public $Subject; // string
    public $IsActive; // boolean
    public $IsHTMLPaste; // boolean
    public $ClonedFromID; // int
    public $Status; // string
    public $EmailType; // string
    public $CharacterSet; // string
    public $HasDynamicSubjectLine; // boolean
    public $ContentCheckStatus; // string
    public $SyncTextWithHTML; // boolean
    public $PreHeader; // string
}
