<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget;

use Eboost\ExactTarget\Exceptions\ExactTargetException;
use Eboost\ExactTarget\Models\ExactTarget_CreateRequest;
use Eboost\ExactTarget\Models\ExactTarget_CreateResponse;
use Eboost\ExactTarget\Models\ExactTarget_DataExtension;
use Eboost\ExactTarget\Models\ExactTarget_Email;
use Eboost\ExactTarget\Models\ExactTarget_EmailSendDefinition;
use Eboost\ExactTarget\Models\ExactTarget_PerformRequestMsg;
use Eboost\ExactTarget\Models\ExactTarget_SendClassification;
use Eboost\ExactTarget\Models\ExactTarget_SendDefinitionList;

class ExactTargetClient
{
    /**
     * Exact Target API WSDL
     */
    const SOAPWSDL = 'http://exacttarget.com/wsdl/partnerAPI';

    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * Create's the SoapClient used for communicating with ExactTarget
     *
     * @param string      $username
     * @param string      $password
     * @param string|null $serverInstance
     */
    public function __construct(string $username, string $password, $serverInstance = null)
    {
        $this->client           = new SoapClient($this->getWsdlUrl($serverInstance), ['trace' => 1]);
        $this->client->username = $username;
        $this->client->password = $password;
    }

    /**
     * Create the WSDL Url for communicating with ExactTarget.
     *
     * @param null $serverInstance
     *
     * @return string
     */
    public function getWsdlUrl($serverInstance = null): string
    {
        if ($serverInstance) {
            $serverInstance .= '.';
        }

        return 'https://webservice.' . $serverInstance . 'exacttarget.com/etframework.wsdl';
    }

    /**
     * Make and creates email in ExactTarget.
     *
     * @param string $customerKey
     * @param string $subject
     * @param string $body
     *
     * @return ExactTarget_CreateResponse
     */
    public function makeAndCreateEmail(string $customerKey, string $subject, string $body): ExactTarget_CreateResponse
    {
        $email = $this->makeEmail($customerKey, $subject, $body);

        return $this->createEmail($email);
    }

    /**
     * Make Email instance
     *
     * @param string $customerKey
     * @param string $subject
     * @param string $body
     *
     * @return ExactTarget_Email
     */
    public function makeEmail(string $customerKey, string $subject, string $body): ExactTarget_Email
    {
        $email = new ExactTarget_Email();

        $email->Name = $customerKey;
        $email->Description = $customerKey;
        $email->HTMLBody = $body;
        $email->Subject = $subject;
        $email->EmailType = 'HTML';
        $email->IsHTMLPaste = 'true';

        return $email;
    }

    /**
     * Create the email in exact target.
     *
     * @param ExactTarget_Email $email
     *
     * @return ExactTarget_CreateResponse|\stdClass
     */
    public function createEmail(ExactTarget_Email $email): ExactTarget_CreateResponse
    {
        $createRequest = new ExactTarget_CreateRequest();
        $createRequest->Options = null;
        $createRequest->Objects = [
            new \SoapVar($email, SOAP_ENC_OBJECT, 'Email', self::SOAPWSDL)
        ];

        $results = $this->client->Create($createRequest);

        return $this->castCreateResponse($results);
    }

    /**
     * Set the email definition list on the email.
     *
     * @param string $customerKey
     * @param string $externalKey
     * @param int    $emailId
     *
     * @return ExactTarget_CreateResponse
     */
    public function setEmailDefinition(string $customerKey, string $externalKey, int $emailId): ExactTarget_CreateResponse
    {
        $emailSendDef = new ExactTarget_EmailSendDefinition();

        $sendClass = new ExactTarget_SendClassification();
        $sendClass->CustomerKey = 'Default Commercial';

        $list = new ExactTarget_DataExtension();
        $list->ObjectID = $externalKey;

        $sendDefList = new ExactTarget_SendDefinitionList();
        $sendDefList->DataSourceTypeID = 'CustomObject';
        $sendDefList->SendDefinitionListType = 'SourceList';
        $sendDefList->CustomObject = $list;
        $sendDefList->CustomerKey = $externalKey;

        $email = new ExactTarget_Email();
        $email->ID = $emailId;

        $emailSendDef->CustomerKey = $customerKey;
        $emailSendDef->Name = $customerKey;
        $emailSendDef->SendClassification = $sendClass;
        $emailSendDef->SendDefinitionList[] = $sendDefList;
        $emailSendDef->Email = $email;

        $object = new \SoapVar($emailSendDef, SOAP_ENC_OBJECT, 'EmailSendDefinition', self::SOAPWSDL);

        $request = new ExactTarget_CreateRequest();
        $request->Options = NULL;
        $request->Objects = [$object];

        $results = $this->client->Create($request);

        return $this->castCreateResponse($results);
    }

    /**
     * Send the email.
     *
     * @param string $customerKey
     *
     * @return ExactTarget_CreateResponse|mixed
     */
    public function sendEmail(string $customerKey): ExactTarget_CreateResponse
    {
        $emailSendDefinition = new ExactTarget_EmailSendDefinition();
        $emailSendDefinition->CustomerKey = $customerKey;

        $performRequestMsg = new ExactTarget_PerformRequestMsg();
        $performRequestMsg->Action = 'start';
        $performRequestMsg->Definitions[] = new \SoapVar($emailSendDefinition, SOAP_ENC_OBJECT,
            'EmailSendDefinition', self::SOAPWSDL);
        $performRequestMsg->Options = NULL;

        $results = $this->client->Perform($performRequestMsg);

        return $this->castCreateResponse($results);
    }

    /**
     * @param \stdClass $result
     *
     * @return ExactTarget_CreateResponse
     * @throws ExactTargetException
     */
    private function castCreateResponse(\stdClass $result): ExactTarget_CreateResponse
    {
        if ($result->OverallStatus !== 'OK') {
            throw new ExactTargetException($result);
        }

        return new ExactTarget_CreateResponse($result);
    }
}
