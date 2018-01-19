<?php

class InContact {

    const API_VERSION = 'services/v10.0';

    function __construct($config) {

        $this->config = $config;
        $this->auth();

    }

    /**
     * Initialize an authenticated session with the inContact API.
     */
    function auth() {

        // Set up the request parameters to request a session token from the API.
        $request_body = [
        	'grant_type' => 'password',
        	'username' => $this->config['username'],
        	'password' => $this->config['password'],
        	'scope' => ''
        ];

        // Construct an "Authorization Key".
        // See https://developer.incontact.com/Documentation/CreateAnAuthorizationKey
        $authorization_key = base64_encode($this->config['application-name']
                                         . '@'
                                         . $this->config['vendor-name']
                                         . ':'
                                         . $this->config['business-unit']);

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
        $response = file_get_contents($this->config['authentication-url'], false, $request_context);

        $response_data = json_decode($response, true);

        // Capture the received data (token, etc).
        $this->api_scope = $response_data['scope'];
        $this->api_token = $response_data['access_token'];
        $this->api_token_type = $response_data['token_type'];
        $this->api_token_expires = $response_data['expires_in'];
        $this->api_base_uri = $response_data['resource_server_base_uri'];

    }

    /**
     * Perform an API request.
     */
    function request($api_url, $method, $request_body = false) {

        // TODO: handle session caching and token expiration!

        // Set up HTTP headers and request options for the API call.
        $request_headers = [
            'Accept: application/json',
            'Authorization: ' . $this->api_token_type . ' ' . $this->api_token,
            'Content-type: application/x-www-form-urlencoded',
            'Content-length: ' . ($request_body ? strlen(http_build_query($request_body)) : 0),
        ];

        $request_options = [
        	'http' => [
        		'method' => $method,
                'header' => implode("\r\n", $request_headers),
                'content' => $request_body ? http_build_query($request_body) : '',
        	]
        ];

        $request_context = stream_context_create($request_options);

        $request_url = $this->api_base_uri . self::API_VERSION . $api_url;

        // Perform the API request.
        $response = file_get_contents($request_url, false, $request_context);

        // Decode and return the response.
        return json_decode($response, true);

    }

    public function get($api) {
        return $this->request($api, 'GET');
    }

    public function post($api, $data) {
        return $this->request($api, 'POST', $data);
    }

}
