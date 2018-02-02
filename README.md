# inContact API

PHP client library for the [inContact API](https://developer.incontact.com/api/).

# Installation

[Composer](https://getcomposer.org/) is the recommended way to install this library.

`composer require antsar/incontact`

# Usage

```php
// Autoload the inContact class.
require __DIR__ . '/vendor/autoload.php';

// Create an API client instance.
$inContact = new \antsar\incontact\InContact(
    'exampleApp',       // Application Name as registered with inContact
    'exampleCompany',   // Vendor Name as registered with inContact
    '012345',           // Business Unit number as registered with inContact
    'exampleUser',      // inContact User Name
    'hunter2'           // inContact User Password
);

// Get status for all agents
$agents = $inContact->get('/agents/states');

// Request a call-back
$response = $inContact->post('/queuecallback', ['phoneNumber' => '8005550100']);
```

For more details, please see:

* [InContact class documentation](doc/) - API documentation for the `\antsar\InContact\InContact` class.
* [inContact API documentation](https://developer.incontact.com/API) - list of available API methods


# Status

This library is very rudimentary, and could be improved. Contributions (issues or pull requests) are welcome and appreciated.

# Changes

See [CHANGELOG.md](CHANGELOG.md).

# Development

See [CONTRIBUTING.md](CONTRIBUTING.md).
