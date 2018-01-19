# inContact API

PHP client library for the [inContact API](https://developer.incontact.com/api/).

# Installation

* Install this package, probably using [Composer](https://getcomposer.org/).
* Require the incontact class ([autoloading](https://getcomposer.org/doc/01-basic-usage.md#autoloading) is a good way to do this)

# Usage

```php
require __DIR__ . '/vendor/autoload.php';

$incontact_options = array(
    // Authentication URL
    'authentication-url' => 'https://api.incontact.com/InContactAuthorizationServer/Token',

    // Application Name as registered for the inContact API
    'application-name' => '',

    // Vendor Name for the inContact API Application
    'vendor-name' => '',

    // Business Unit number for the inContact API Application
    'business-unit' => '',

    // inContact User Name
    'username' => '',

    // inContact User Password
    'password' => ''
);

$inContact = new \antsar\incontact\InContact($incontact_options);

// Get status for all agents
$agents = $inContact->get('/agents/states');

// Request a call-back
$response = $inContact->post('/queuecallback', ['phoneNumber' => '8005550100']);
```

See the [inContact API documentation](https://developer.incontact.com/API) for available API methods.
