EBOOST ExactTarget Client  (SalesForce)
========

The ExactTarget component is a collection of classes based on the 
[ExactTarget PHP starter kit.](https://developer.salesforce.com/docs/atlas.en-us.mc-apis.meta/mc-apis/api_starter_kits.htm)  

To create this package I have used [druid628/exacttarget](https://github.com/druid628/exacttarget) as a guideline, thanks!

Installation  
------------

```bash
composer require eboost/exact-target
```

Example
-----

This example sends an email to a data extension.

```php
$externalKey = 'SOME_KEY_GENERATED_IN_EXACT_TARGET';
$customerKey = 'some_random_key';
$htmlBody = '<b>This email was sent by %%Member_Busname%%  %%Member_Addr%% %%Member_City%%, %%Member_State%%, %%Member_PostalCode%%, %%Member_Country%%</b>';

$client = new ExactTargetClient($username, $password, $instance);

$result = $client->makeAndCreateEmail($customerKey, 'Subject of the email', $htmlBody);
$emailId = $result->Results->NewID;

$client->setEmailDefinition($customerKey, $externalKey, $emailId);
$client->sendEmail($customerKey);
```
