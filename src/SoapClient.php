<?php
declare(strict_types = 1);

namespace Eboost\ExactTarget;

class SoapClient extends \SoapClient
{
    public $username = null;
    public $password = null;

    public function __doRequest($request, $location, $saction, $version, $one_way = 0)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($request);

        $objWSSE = new \druid628\exactTarget\WSSE\WSSESoap($doc);

        $objWSSE->addUserToken($this->username, $this->password, false);

        return parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version, $one_way);
    }
}
