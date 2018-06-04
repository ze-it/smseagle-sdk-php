# smseagle-sdk-php

## Prerequisites

* PHP >= 5.6
* ext-curl
* ext-simplexml

## Usage

### Configure client
```php
<?php

$api = new Zeit\SmsEagle\Api([
    'type' => 'http', // or json
    'transport' => [
        'login' => 'login',
        'password'  => 'pass',
        'url' => 'https://sms.eagle/index.php/',
    ],
]);
```

One can pass additional options for cURL (for ex. when using self-signed certs on dev environment)
```php
<?php

$api = new Zeit\SmsEagle\Api([
    'type' => 'http',
    'transport' => [
        'login' => 'login',
        'password'  => 'pass',
        'url' => 'https://sms.eagle/index.php/',
        'options' => [
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ]
        ],
    ],
]);
```

### Send message

#### Text message
```php
# one recipient
$api->sms->send('text', '555555555'); // [102]

# multiple recipients
$api->sms->send('other msg', ['555555555', '555555556']); // [103, 104]

# contact saved in phonebook
$api->sms->sendToContact('happy birthday!', 'best friend'); // [105]

# group saved in phonebook (must be public!)
$api->sms->sendToGroup('byob 2nigh!', 'my best friends'); // [106, 107]

# schedule sending flash message for May 25th 2018 12:00
$api->sms->send('scheduled flash message', '555555555', [
    'flash' => true,
    'date' => new DateTime('2018-05-25 12:00'),
]); // [108]
```

`send()` method support additional param:
* oid (string|null) - user defined unique message identifier (up to 36 characters), it allows to match incoming reply messages to outgoing messages,

`send()`, `sendToContact()`, `sendToGroup()` methods support additional params:
* date (DateTime|null) - message will be queued for given date or sent imidietelly if null (default: null),
* flash (bool) - message will be sent as flash message (default: false),
* highpriority (bool) - message will have higher priority in outbox queue (default: false),
* unicode (bool) - message will be encoded with unicode (defalut: false),
* modemNo (int|null) - sending modem number (only for multimodem devices) (default: null).

#### Binary message
```php
# send binary message
$api->sms->sendBinary('73696d706c652062696e6172792074657374', '555555555', [
    'udh' => '7564682074657374',
]); // [109]
```
`sendBinary()` method support additional params:
* udh (string|null) - UDH header (default: null),
* class (string|null) - message class (default: null),
* modemNo (int|null) - sending modem number (only for multimodem devices) (default: null).

#### USSD
```php
$api->ussd->send('*#06#'); // [110]
```
`send()` methods support additional params:
* modemNo (int|null) - sending modem number (only for multimodem devices) (default: null).

### Delete message(s)

#### Inbox 
```php
# delete message with given id
$api->sms->deleteInbox(10); // true

# delete messages with given id range
$api->sms->deleteInbox(10, 15); // true
```

#### Sent
```php
# delete message with given id
$api->sms->deleteSent(102); // true

# delete messages with given id range
$api->sms->deleteSent(102, 105); // true
```

#### Outbox
```php
# delete message with given id
$api->sms->deleteOutbox(15); // true

# delete messages with given id range
$api->sms->deleteOutbox(16, 17); // true
```

### Search folders

#### Sent
```php
# get all messages sent to 555555555
$api->sms->searchSent(null, null, '555555555');// Sms[]

# get up to 4 sent messages between 06/01/2018 and 06/02/2018
$api->sms->searchSent(new DateTime('2018-06-01'), new DateTime('2018-06-02'), null, 4);// Sms[]
```

#### Outbox
```php
# get all queued messages to 555555555
$api->sms->searchOutbox(null, null, '555555555');// Sms[]

# get up to 5 queued messages sent between 06/01/2018 and 06/02/2018
$api->sms->searchOutbox(new DateTime('2018-06-01'), new DateTime('2018-06-02'), null, 5);// Sms[]
```

#### Inbox
```php
# get all unread messages received from 555555555
$api->sms->searchInbox(null, null, '555555555', true);// Sms[]

# get up to 6 messages received between 06/01/2018 and 06/02/2018
$api->sms->searchInbox(new DateTime('2018-06-01'), new DateTime('2018-06-02'), null, null, 6); // Sms[]
```

#### Response
Methods `searchSent`, `searchOutbox`, `searchInbox` returns array of  `Zeit\SmsEagle\Response\Sms` objects. Available getters:
* getId() - message id (int),
* getText() - message text/binary data (string),
* getCoding() - message coding (string),
* getCreatorId() - creator id (string|null),
* getSmsCenterNumber() - sms center number (string),
* getStatus() - message status (string|null),
* getStatusError() - message status error (string|null),
* getUdh() - message UDH (string|null),
* getUpdatedAt() - update date in SmsEagle database (DateTime|null),
* getInsertedAt() - insert date in SmsEagle database (DateTime|null).

Additional getters available for `searchSent`, `searchOutbox` methods:
* getTo() - recipient phone number (string),
* getSentAt() - sent date (DateTime|null).


Additional getters available for `searchInbox` method:
* getFrom() - sender phone number (string),
* getRead() - read status (bool),
* getOid() - message oid (string|null),
* getSentAt() - sent date (DateTime|null).

### Qty
```php
# sent messages qty
$api->sms->sentQty(); // 3

# received messages qty
$api->sms->inboxQty(); // 1

# queued messages qty
$api->sms->queueLength(); // 0
```

### Phonebook
to be done

