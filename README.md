# inContact API

PHP client library for the [inContact API](https://developer.incontact.com/api/).

# Installation

[Composer](https://getcomposer.org/) is the recommended way to install and use this library.

`composer require antsar/incontact`

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

# Status

This library is very rudimentary, and could be improved. Contributions (issues or pull requests) are welcome and appreciated.
