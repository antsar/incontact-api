<?php
/**
 * This file defines the main inContact API client class.
 *
 * PHP Version 7
 *
 * @category InContact
 * @package  InContact
 * @author   Anton Sarukhanov <code@ant.sr>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/antsar/incontact-api
 */

namespace antsar\InContact;


/**
 * Client class for the inContact API.
 *
 * @category InContact
 * @package  InContact
 * @author   Anton Sarukhanov <code@ant.sr>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/antsar/incontact-api
 *
 * @api
 */
class InContact
{

    const AUTH_URL = 'https://api.incontact.com/InContactAuthorizationServer/Token';
    const API_VERSION = 'services/v10.0';

    /**
     * Application Name, as configured with the inContact API.
     *
     * @var string $application_name inContact Application Name
     */
    protected $application_name;

    /**
     * Application Name, as configured with the inContact API.
     *
     * @var string $vendor_name inContact Vendor Name
     */
    protected $vendor_name;

    /**
     * Application Name, as configured with the inContact API.
     *
     * @var string $business_unit inContact Business Unit number
     */
    protected $business_unit;

    /**
     * Username for the inContact API.
     *
     * @var string $username inContact User Name
     */
    protected $username;

    /**
     * Password for the inContact API.
     *
     * @var string $password inContact User Password
     */
    protected $password;

    /**
     * Instantiate the class, storing the authentication parameters.
     *
     * @param string  $application_name inContact Application Name
     * @param string  $vendor_name      inContact Vendor Name
     * @param string  $business_unit    inContact Business Unit number
     * @param string  $username         inContact User Name
     * @param string  $password         inContact User Password
     * @param boolean $authenticate     Auth right away (instead of first request).
     *
     * @api
     */
    function __construct(
        $application_name,
        $vendor_name,
        $business_unit,
        $username,
        $password,
        $authenticate = false
    ) {
        $this->application_name = $application_name;
        $this->vendor_name = $vendor_name;
        $this->business_unit = $business_unit;
        $this->username = $username;
        $this->password = $password;

        if ($authenticate) {
            $this->auth();
        }
    }

    /**
     * Initialize an authenticated session with the inContact API.
     *
     * @api
     * @return null
     */
    function auth()
    {

        // Set up the request parameters to request a session token from the API.
        $request_body = [
            'grant_type' => 'password',
            'username' => $this->username,
            'password' => $this->password,
            'scope' => ''
        ];

        // Construct an "Authorization Key".
        // See https://developer.incontact.com/Documentation/CreateAnAuthorizationKey
        $authorization_key = base64_encode(
            $this->application_name
            . '@'
            . $this->vendor_name
            . ':'
            . $this->business_unit
        );

        $request_headers = [
            'Authorization: basic ' . $authorization_key,
            'Content-type: application/x-www-form-urlencoded'
        ];

        $request_options = [
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $request_headers),
                'content' => http_build_query($request_body),
            ]
        ];

        $request_context = stream_context_create($request_options);

        // Perform the API request for authentication.
        $response = file_get_contents(
            $this::AUTH_URL,
            false,
            $request_context
        );
        $response_data = json_decode($response, true);

        // Capture the received data (token, etc).
        $this->api_scope = $response_data['scope'];
        $this->api_token = $response_data['access_token'];
        $this->api_token_type = $response_data['token_type'];
        $this->api_token_expires = time() + $response_data['expires_in'];
        $this->api_base_uri = $response_data['resource_server_base_uri'];

        // TODO: Handle failure.
    }

    /**
     * Perform an API request.
     *
     * @param string $api_url      The API method to call (eg. `"/queuecallback"`)
     * @param string $method       HTTP method (eg. `"POST"`, `"GET"`)
     * @param array  $request_body Request parameters
     *
     * @return array  Response data
     *
     * @api
     */
    function request($api_url, $method, $request_body = array())
    {

        // If token is missing or expired, get a new one.
        if (!isset($this->api_token) || $this->api_token_expires <= time()) {
            $this->auth();
        }

        // Set up HTTP headers and request options for the API call.
        $request_headers = [
            'Accept: application/json',
            'Authorization: ' . $this->api_token_type . ' ' . $this->api_token,
            'Content-type: application/x-www-form-urlencoded',
            'Content-length: ' . strlen(http_build_query($request_body)),
        ];

        $request_options = [
            'http' => [
                'method' => $method,
                'header' => implode("\r\n", $request_headers),
                'content' => http_build_query($request_body),
            ]
        ];

        $request_context = stream_context_create($request_options);

        $request_url = $this->api_base_uri . self::API_VERSION . $api_url;

        // Perform the API request.
        $response = file_get_contents($request_url, false, $request_context);

        // TODO: Handle failure.

        // Decode and return the response.
        return json_decode($response, true);

    }

    /**
     * Perform a GET-type API request.
     *
     * @param string $api_url The API method to call (eg. "/agents/states")
     *
     * @return array  Response data
     *
     * @api
     */
    public function get($api_url)
    {
        return $this->request($api_url, 'GET');
    }

    /**
     * Perform a POST-type API request.
     *
     * @param string $api_url The API method to call (eg. "/queuecallback")
     * @param array  $data    Request parameters
     *
     * @return array  Response data
     *
     * @api
     */
    public function post($api_url, $data)
    {
        return $this->request($api_url, 'POST', $data);
    }

}
