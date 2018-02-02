# API Documentation

## Table of Contents

* [InContact](#incontact)
    * [__construct](#__construct)
    * [auth](#auth)
    * [request](#request)
    * [get](#get)
    * [post](#post)

## InContact

Client class for the inContact API.



* Full name: \antsar\InContact\InContact

**See Also:**

* https://github.com/antsar/incontact-api 

### __construct

Instantiate the class, storing the authentication parameters.

```php
InContact::__construct( string $application_name, string $vendor_name, string $business_unit, string $username, string $password, boolean $authenticate = false )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$application_name` | **string** | inContact Application Name |
| `$vendor_name` | **string** | inContact Vendor Name |
| `$business_unit` | **string** | inContact Business Unit number |
| `$username` | **string** | inContact User Name |
| `$password` | **string** | inContact User Password |
| `$authenticate` | **boolean** | Auth right away (instead of first request). |




---

### auth

Initialize an authenticated session with the inContact API.

```php
InContact::auth(  ): null
```







---

### request

Perform an API request.

```php
InContact::request( string $api_url, string $method, array $request_body = array() ): array
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$api_url` | **string** | The API method to call (eg. `"/queuecallback"`) |
| `$method` | **string** | HTTP method (eg. `"POST"`, `"GET"`) |
| `$request_body` | **array** | Request parameters |


**Return Value:**

Response data



---

### get

Perform a GET-type API request.

```php
InContact::get( string $api_url ): array
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$api_url` | **string** | The API method to call (eg. "/agents/states") |


**Return Value:**

Response data



---

### post

Perform a POST-type API request.

```php
InContact::post( string $api_url, array $data ): array
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$api_url` | **string** | The API method to call (eg. "/queuecallback") |
| `$data` | **array** | Request parameters |


**Return Value:**

Response data



---



--------
> This document was automatically generated from source code comments on 2018-02-02 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
