<?php

namespace RyanSechrest\Taleo;

require_once 'Error.php';

/**
 * Api.php
 *
 * Object for interfacing with the Taleo Business Edition API.
 *
 * @author Ryan Sechrest
 * @version 1.0.0
 */
class Api
{
	/**
	 * Authentication token
	 *
	 * Authentication token, if not manually set, is automatically obtained
	 * from Taleo and set in this object upon login.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $auth_token = '';

	/**
	 * Company code
	 *
	 * Company code is provided by Taleo when signing up.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $company_code = '';

	/**
	 * Errors
	 *
	 * Errors will contain an array of Error objects that are populated with
	 * erroneous Taleo API responses.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var array
	 */
	private $errors = array();

	/**
	 * Host URL
	 *
	 * Host URL, if not manually set, is automatically obtained from Taleo
	 * and set in this object upon login.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $host_url = '';

	/**
	 * Password
	 *
	 * Password of the user in $username.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $password = '';

	/**
	 * Service URL
	 *
	 * Service URL can be found in the API documentation, but is, at the time of
	 * this writing, https://tbe.taleo.net/MANAGER/dispatcher/api/v1/serviceUrl/
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $service_url = '';

	/**
	 * Username
	 *
	 * Username of the user that will be connecting via the API. This user must
	 * be created within the Taleo Business Edition GUI and must have
	 * administrative privileges.
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $username = '';

	/*************************************************************************/

	/**
	 * Default constructor
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $company_code Company code
	 * @param string $username Username
	 * @param string $password Password
	 * @param string $service_url Service URL
	 */
	public function __construct(
		$company_code = '',
		$username = '',
		$password = '',
		$service_url = ''
	) {
		$this->auth_token = '';
		$this->company_code = $company_code;
		$this->errors = array();
		$this->host_url = '';
		$this->password = $password;
		$this->service_url = $service_url;
		$this->username = $username;
	}

	/*************************************************************************/

	/**
	 * Get authentication token
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Authentication token
	 */
	public function get_auth_token() {
		return $this->auth_token;
	}

	/**
	 * Set authentication token
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $auth_token Authentication token
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_auth_token($auth_token) {
		$this->auth_token = $auth_token;

		return true;
	}

	/**
	 * Get company code
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Company code
	 */
	public function get_company_code() {
		return $this->company_code;
	}

	/**
	 * Set company code
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $company_code Company code
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_company_code($company_code) {
		$this->company_code = $company_code;

		return true;
	}

	/**
	 * Get errors
	 *
	 * Gives an array of Error objects containing erroneous responses from
	 * the Taleo API.
	 *
	 * @return array Array of Error objects
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Get host URL
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Host URL
	 */
	public function get_host_url() {
		return $this->host_url;
	}

	/**
	 * Set host URL
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $host_url Host URL
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_host_url($host_url) {
		$this->host_url = $host_url;

		return true;
	}

	/**
	 * Get password
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Password
	 */
	public function get_password() {
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $password Password
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_password($password) {
		$this->password = $password;

		return true;
	}

	/**
	 * Get service URL
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Service URL
	 */
	public function get_service_url() {
		return $this->service_url;
	}

	/**
	 * Set service URL
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $service_url Service URL
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_service_url($service_url) {
		$this->service_url = $service_url;

		return true;
	}

	/**
	 * Get username
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string Username
	 */
	public function get_username() {
		return $this->username;
	}

	/**
	 * Set username
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $username Username
	 * @return bool TRUE = set, FALSE = not set
	 */
	public function set_username($username) {
		$this->username = $username;

		return true;
	}

	/*************************************************************************/

	/**
	 * Debug variable
	 *
	 * Print out variable and variable name for debugging purposes.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param mixed $mixed Variable
	 * @param string $name Name of variable
	 */
	public function debug($mixed, $name = '') {
		if (!empty($name)) {
			echo '<pre>' . $name . '</pre>';
		}
		echo '<pre>' . print_r($mixed, true) . '</pre>';
	}

	/**
	 * Fetch authentication token
	 *
	 * Retrieves new authentication token from Taleo. Note that the token is
	 * not stored, only retrieved.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string|bool Authentication token or FALSE = unable to fetch
	 */
	public function fetch_auth_token() {
		$request = array(
			'path' => $this->get_request_path('login'),
			'method' => 'post',
			'query' => array(
				'orgCode' => $this->company_code,
				'userName' => $this->username,
				'password' => $this->password
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$auth_token = $response->response->authToken;

		return $auth_token;
	}

	/**
	 * Fetch host URL
	 *
	 * Retrieves host URL from Taleo. Note that the URL is not stored,
	 * only retrieved.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return string|bool Host URL or FALSE = unable to fetch
	 */
	public function fetch_host_url() {
		$request = array(
			'host' => $this->service_url,
			'path' => $this->company_code
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$host_url = $response->response->URL;

		return $host_url;
	}

	/**
	 * Login
	 *
	 * Login to Taleo. If host URL and authentication token are not manually
	 * set, it retrieves them from Taleo and saves them in this object.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return bool TRUE = logged in, FALSE = not logged in
	 */
	public function login() {
		if ($this->is_blank($this->host_url)) {
			if (!$host_url = $this->fetch_host_url()) {
				return false;
			}
			$this->host_url = $host_url;
		}
		if ($this->is_blank($this->auth_token)) {
			if (!$auth_token = $this->fetch_auth_token()) {
				return false;
			}
			$this->auth_token = $auth_token;
		}

		return true;
	}

	/**
	 * Logout
	 *
	 * Logout of Taleo. Releases the currently set authentication token from
	 * Taleo and then removes both the authentication token and the host URL
	 * from this object.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @return bool TRUE = logged out, FALSE = not logged out
	 */
	public function logout() {
		if (!$this->release_auth_token($this->auth_token)) {
			return false;
		}
		$this->auth_token = '';
		$this->host_url = '';

		return true;
	}

	/**
	 * Make request
	 *
	 * Makes a request to Taleo. Accepts a request, adds any missing values
	 * it can, makes the request, and returns the response.
	 *
	 * The request array can consist of the following values:
	 *   url          Complete URL to make request, i.e., http://host/some/path
	 *   host         Host URL to use for making request, i.e., http://host/
	 *   path         Specific path to append to host URL, i.e., some/path
	 *   query        Array of query variables in form of name => value
	 *   cookie       Array of cookies to set in form of name => value
	 *   http_header  Array of headers to set in form of name => value
	 *   method       Request method to use, i.e., POST, GET, DELETE etc.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param array $request Request
	 * @return mixed cURL response
	 */
	public function make_request($request) {
		$request = $this->add_missing_request_values($request);
		if (!$response = $this->make_curl_request($request)) {
			return false;
		}
		switch ($request['http_header']['Content-Type']) {
			case 'application/json':
				$response = json_decode($response);
				if (json_last_error() != JSON_ERROR_NONE) {
					return false;
				}
				if (!$response->status->success) {
					$error = new Error(
						$request,
						$response->status->detail->errormessage,
						$response->status->detail->operation,
						$response->status->detail->errorcode,
						$response->status->detail->error
					);
					$this->log_error($error);
					return false;
				}
				break;
		}

		return $response;
	}

	/**
	 * Release authentication token
	 *
	 * Accepts an authentication token and releases it from Taleo.
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $auth_token Authentication token
	 * @return bool TRUE = released or FALSE = not released
	 */
	public function release_auth_token($auth_token) {
		$request = array(
			'path' => $this->get_request_path('logout'),
			'method' => 'post',
			'cookie' => array(
				'authToken' => $auth_token
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}

		return true;
	}

	/*************************************************************************/

	/**
	 * Get entities
	 *
	 * Gives you an array of all the entities in Taleo, including their
	 * meta data and properties.
	 *
	 * @author Ryan Sechrest
	 * @return array|bool Entities or FALSE
	 */
	public function get_entities() {
		$request = array(
			'path' => $this->get_request_path('entities')
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$entities = $response->response->objects;

		return $entities;
	}

	/**
	 * Get entity
	 *
	 * Gives you the meta data and properties of an entity.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return object|bool Entity or FALSE
	 */
	public function get_entity($entity_name) {
		$request = array(
			'path' => sprintf(
				$this->get_request_path('entity'),
				$entity_name
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$entity = $response->response;

		return $entity;
	}

	/**
	 * Get entity code
	 *
	 * Gives you the entity code from an entity e.g. if you provided
	 * it with 'requisition', it might return 'REQU'.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return string|bool Entity code name or FALSE
	 */
	public function get_entity_code($entity_name) {
		if (!$entity_label = $this->get_entity_label($entity_name)) {
			return false;
		}
		$request = array(
			'path' => sprintf(
				$this->get_request_path('entity_standard_fields'),
				$entity_label
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$entity_code = $response->response->code;

		return $entity_code;
	}

	/**
	 * Get entity custom fields
	 *
	 * Gives you an array of custom fields of an entity.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return array|bool Custom fields or FALSE
	 */
	public function get_entity_custom_fields($entity_name) {
		if (!$entity_label = $this->get_entity_label($entity_name)) {
			return false;
		}
		$request = array(
			'path' => sprintf(
				$this->get_request_path('entity_custom_fields'),
				$entity_label
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$custom_fields = $response->response->fields;

		return $custom_fields;
	}

	/**
	 * Get entity field
	 *
	 * Gives you meta data and properties of a specific field of an entity.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param string $field_name Field name
	 * @return object|bool Entity field or FALSE
	 */
	public function get_entity_field($entity_name, $field_name) {
		if (!$entity_code = $this->get_entity_code($entity_name)) {
			return false;
		}
		$request = array(
			'path' => sprintf(
				$this->get_request_path('entity_field'),
				$entity_code,
				$field_name
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$entity_field = $response->response->displayfield->$field_name;

		return $entity_field;
	}

	/**
	 * Get entity field values
	 *
	 * Gives you all possible values for a picklist field, for example.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param string $field_name Field name
	 * @return array|bool Entity field values or FALSE
	 */
	public function get_entity_field_values($entity_name, $field_name) {
		if (!$entity_field =
			$this->get_entity_field($entity_name,$field_name)) {
			return false;
		}
		if (!property_exists($entity_field, 'lookupValues')) {
			return false;
		}
		$entity_field_values = $entity_field->lookupValues;

		return $entity_field_values;
	}

	/**
	 * Get all fields of an entity
	 *
	 * Gives you both standard and custom fields of an entity.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return array|bool Entity fields or FALSE
	 */
	public function get_entity_fields($entity_name) {
		if (!$standard_fields =
			$this->get_entity_standard_fields($entity_name)) {
			return false;
		}
		if (!$custom_fields = $this->get_entity_custom_fields($entity_name)) {
			return false;
		}
		$entity_fields = array_merge($standard_fields, $custom_fields);

		return $entity_fields;
	}

	/**
	 * Get entity label
	 *
	 * Gives you the entity label from an entity e.g. if you provided
	 * it with 'requisition', it might return 'REQU'.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return string|bool Entity label or FALSE
	 */
	public function get_entity_label($entity_name) {
		if (!$entity = $this->get_entity($entity_name)) {
			return false;
		}
		$entity_label = $entity->label;

		return $entity_label;
	}

	/**
	 * Get standard fields of an entity
	 *
	 * Gives you an array of built-in fields of an entity.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @return array|bool Standard fields or FALSE
	 */
	public function get_entity_standard_fields($entity_name) {
		if (!$entity_label = $this->get_entity_label($entity_name)) {
			return false;
		}
		$request = array(
			'path' => sprintf(
				$this->get_request_path('entity_standard_fields'),
				$entity_label
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$standard_fields = $response->response->fields;

		return $standard_fields;
	}

	/**
	 * Get a record
	 *
	 * Gives you the data of a specific record.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param int $record_id Record ID
	 * @return object|bool Record or FALSE
	 */
	public function get_record($entity_name, $record_id) {
		$request = array(
			'path' => sprintf(
				$this->get_request_path('record'),
				$entity_name,
				$record_id
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$record = $response->response->$entity_name;

		return $record;
	}

	/**
	 * Get records
	 *
	 * Gives you either all records (up to the limit) or lets you search and
	 * filter for specific records.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param array $query Search arguments
	 * @return array|bool Records or FALSE
	 */
	public function get_records($entity_name, $query = array()) {
		$records = array();
		$request = array(
			'path' => sprintf(
				$this->get_request_path('records_search'),
				$entity_name
			)
		);
		$request['query'] = $query;
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$records = $response->response;

		return $records;
	}

	/**
	 * Get a related record
	 *
	 * When retrieving requisitions, for example, there may be users
	 * attached to that requisition. Those are specific, related records
	 * that can be retrieved with this method.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param int $record_id Record ID
	 * @param string $related_entity_name Related entity name
	 * @return object|bool Related record or FALSE
	 */
	public function get_related_record(
		$entity_name,
		$record_id,
		$related_entity_name
	) {
		$request = array(
			'path' => sprintf(
				$this->get_request_path('related_record'),
				$entity_name,
				$record_id,
				$related_entity_name
			)
		);
		if (!$response = $this->make_request($request)) {
			return false;
		}
		$related_entity_name =
			$this->find_entity_name($response->response, $related_entity_name);
		if (property_exists($response->response, $related_entity_name)) {
			$related_record = $response->response->$related_entity_name;
		} else {
			$related_record = $response->response;
		}

		return $related_record;
	}

	/**
	 * Get related records
	 *
	 * When retrieving requisitions, for example, there may be users,
	 * candidates, career websites, etc, attached to that requisition. All
	 * related records can be retrieved with this method or you can
	 * provide an array of related entitites whose records to retrieve.
	 *
	 * @author Ryan Sechrest
	 * @param string $entity_name Entity name
	 * @param int $record_id Record ID
	 * @param array $related_entity_names Related entity names
	 * @return array|bool Related records or FALSE
	 */
	public function get_related_records(
		$entity_name,
		$record_id,
		$related_entity_names = array()
	) {
		if (!empty($related_entity_names)) {
			foreach ($related_entity_names as $related_entity_name) {
				if ($related_record =
						$this->get_related_record(
							$entity_name,
							$record_id,
							$related_entity_name
						)
					) {
					$related_records[$related_entity_name] = $related_record;
				}
			}
		} else {
			if (!$record = $this->get_record($entity_name, $record_id)) {
				return false;
			}
			foreach ($record->$entity_name->relationshipUrls as
				$related_entity_name => $relationship_url) {
				$request = array(
					'url' => $relationship_url
				);
				if ($response = $this->make_request($request)) {
					$related_entity_name =
						$this->find_entity_name(
							$response->response,
							$related_entity_name
						);
				}
				if (property_exists(
					$response->response,
					$related_entity_name)
				) {
					$related_records[$related_entity_name] =
						$response->response->$related_entity_name;
				} else {
					$related_records[$related_entity_name] =
						$response->response;
				}
			}
		}
		if (empty($related_records)) {
			return false;
		}

		return $related_records;
	}

	/*************************************************************************/

	/**
	 * Add missing request values
	 *
	 * This ensures that necessary request defaults are set and attempts to add
	 * anything that may have been missed. Alternatively, it also allows
	 * everything to be overwritten by supplying custom request values.
	 *
	 * @author Ryan Sechrest
	 * @param array $request Request
	 * @return array Request
	 */
	private function add_missing_request_values($request) {
		if (!isset($request['url'])) {
			if (!isset($request['host'])) {
				$request['url'] = $request['host'] = $this->host_url;
			} else {
				$request['url'] = $request['host'];
			}
			if (isset($request['path'])) {
				$request['url'] = $this->fix_trailing_slash(
					$request['url'],
					'ensure'
				);
				$request['url'] .= $request['path'];
			}
		}
		if (isset($request['query'])) {
			$request['url'] .= '?' . $this->convert_array_to_query_string(
				$request['query']
			);
		}
		if (!isset($request['cookie']['authToken'])) {
			$request['cookie']['authToken'] = $this->auth_token;
		}
		if (!isset($request['http_header']['Content-Type'])) {
			$request['http_header']['Content-Type'] = 'application/json';
		}
		if (isset($request['method']) && $request['method'] == 'post' && !isset($request['post_fields'])) {
			$request['post_fields'] = '';
		}
		if (!isset($request['return_transfer'])) {
			$request['return_transfer'] = 1;
		}

		return $request;
	}

	/**
	 * Convert array to cookie string
	 *
	 * Converts array
	 *     ['key' => 'value', 'key' => 'value']
	 * to string
	 *     'key=value; key=value'
	 *
	 * @author Ryan Sechrest
	 * @param array $cookie Cookie
	 * @return string Cookie
	 */
	private function convert_array_to_cookie_string($cookie) {
		$cookie_string = '';
		if (is_array($cookie) && !empty($cookie)) {
			foreach ($cookie as $key => $value) {
				$cookie_string .= $key . '=' . $value . '; ';
			}
			if ($cookie_string != '') {
				$cookie_string = substr($cookie_string, 0, -2);
			}
		}

		return $cookie_string;
	}

	/**
	 * Convert array to option array
	 *
	 * Converts array
	 *     ['key' => 'value', 'key' => 'value']
	 * to array
	 *     ['key: value', 'key: value']
	 *
	 * @author Ryan Sechrest
	 * @param array $options Options
	 * @return array Options
	 */
	private function convert_array_to_option_array($options) {
		$options_array = array();
		if (is_array($options) && !empty($options)) {
			foreach ($options as $key => $value) {
				$options_array[] = $key . ': ' . $value;
			}
		}
		return $options_array;
	}

	/**
	 * Convert array to query string
	 *
	 * Converts array
	 *     ['key' => 'value', 'key' => 'value']
	 * to string
	 *     'key=value&key=value'
	 *
	 * @author Ryan Sechrest
	 * @param array $query Query
	 * @return string Query
	 */
	private function convert_array_to_query_string($query) {
		$query_string = '';
		if (is_array($query) && !empty($query)) {
			foreach ($query as $key => $value) {
				$query_string .= $key . '=' . $value . '&';
			}
			if ($query_string != '') {
				$query_string = substr($query_string, 0, -1);
			}
		}

		return $query_string;
	}

	/**
	 * Make cURL request
	 *
	 * Translates the request array to actual cURL options.
	 *
	 * @author Ryan Sechrest
	 * @param array $request Request
	 * @return mixed cURL response
	 */
	private function make_curl_request($request) {
		$resource = curl_init();
		if (isset($request['url'])) {
			curl_setopt(
				$resource,
				CURLOPT_URL,
				$request['url']
			);
		}
		if (isset($request['http_header'])) {
			curl_setopt(
				$resource,
				CURLOPT_HTTPHEADER,
				$this->convert_array_to_option_array($request['http_header'])
			);
		}
		if (isset($request['return_transfer'])) {
			curl_setopt(
				$resource,
				CURLOPT_RETURNTRANSFER,
				$request['return_transfer']
			);
		}
		if (isset($request['method'])) {
			switch($request['method']) {
				case 'delete':
					curl_setopt(
						$resource,
						CURLOPT_CUSTOMREQUEST,
						'DELETE'
					);
					break;

				case 'put':
					curl_setopt(
						$resource,
						CURLOPT_CUSTOMREQUEST,
						'PUT'
					);
					break;

				case 'post':
					curl_setopt(
						$resource,
						CURLOPT_POST,
						1
					);
					if (!empty($request['post_fields'])) {
						$request['post_fields'] = json_encode($request['post_fields']);
					}
					curl_setopt(
						$resource,
						CURLOPT_POSTFIELDS,
						$request['post_fields']
					);
					break;
			}
		}
		if (isset($request['cookie'])) {
			curl_setopt(
				$resource,
				CURLOPT_COOKIE,
				$this->convert_array_to_cookie_string($request['cookie'])
			);
		}

		return curl_exec($resource);
	}

	/**
	 * Find entity name
	 *
	 * In order to always ask for entity name (instead of label or code),
	 * sometimes label or code need to be looked up, but because of Taleo's
	 * naming inconsistencies, the property needs to be guessed.
	 *
	 * @author Ryan Sechrest
	 * @param object $related_record Related record
	 * @param string $related_entity_name Related entity name
	 * @return string Most likely entity name
	 */
	private function find_entity_name($related_record, $related_entity_name) {
		if (property_exists($related_record, $related_entity_name . 's')) {
			return $related_entity_name . 's';
		} else if (
			property_exists($related_record, strtolower($related_entity_name))
		) {
			return strtolower($related_entity_name);
		} else {
			return $related_entity_name;
		}
	}

	/**
	 * Add, remove, or toggle trailing slash from string
	 *
	 * Makes sure that requests or paths have a trailing slash when
	 * needed and removes it when it does not.
	 *
	 * @author Ryan Sechrest
	 * @param string $value String to convert
	 * @param string $task Whether to ensure, prevent or toggle slash
	 * @return string Updated string
	 */
	private function fix_trailing_slash($path, $task) {
		$action = 'none';

		// Determine whether path has slash or not
		if (substr($path, -1) == '/') {
			$has_slash = true;
		} else {
			$has_slash = false;
		}

		// Determine action to take based on task
		switch ($task) {
			case 'ensure':
				if(!$has_slash) {
					$action = 'add';
				}
				break;

			case 'prevent':
				if($has_slash) {
					$action = 'remove';
				}
				break;

			case 'toggle':
				if($has_slash) {
					$action = 'remove';
				} else {
					$action = 'add';
				}
				break;
		}

		// Add or remove slash based on determined action
		switch ($action) {
			case 'add':
				$path .= '/';
				break;

			case 'remove':
				$path = substr($path, 0, -1);
				break;
		}

		return $path;
	}

	/**
	 * Get message template
	 *
	 * Array of messages that may be output by this object.
	 *
	 * @author Ryan Sechrest
	 * @param string $slug Slug of message template
	 * @return string Message
	 */
	private function get_message_template($slug) {
		switch ($slug) {
			case 'json_error':
				return 'Taleo returned a JSON object that could not be parsed.';
				break;
		}
	}

	/**
	 * Get request path
	 *
	 * All request paths used by this object when making Taleo requests.
	 * This provides a central place to add and update path templates should
	 * they change in the future.
	 *
	 * @author Ryan Sechrest
	 * @param string $slug Slug of path template
	 * @return string Path template
	 */
	private function get_request_path($slug) {
		switch ($slug) {
			case 'entities':
				return 'object/info';
				break;

			case 'entity':
				return 'object/info/%s';
				break;

			case 'entity_custom_fields':
				return 'object/%s/description/custom';
				break;

			case 'entity_field':
				return 'object/displayfield/%s/%s';
				break;

			case 'entity_standard_fields':
				return 'object/%s/description/standard';
				break;

			case 'entity_statuses':
				return 'object/status/%s';
				break;

			case 'login':
				return 'login';
				break;

			case 'logout':
				return 'logout';
				break;

			case 'record':
				return 'object/%s/%d';
				break;

			case 'records':
				return 'object/%s';
				break;

			case 'records_search':
				return 'object/%s/search';
				break;

			case 'related_record':
				return 'object/%s/%d/%s';
				break;
		}
	}

	/**
	 * Check if value is blank
	 *
	 * @author Ryan Sechrest
	 * @param string $value Value to check
	 * @return bool TRUE = blank, FALSE = not blank
	 */
	private function is_blank($value) {
		if ($value == '') {
			return true;
		}

		return false;
	}

	/**
	 * Log error response
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @param Error $error Error response
	 * @return bool TRUE = logged, FALSE = not logged
	 */
	private function log_error($error) {
		$this->errors[] = $error;

		return true;
	}
}

// EOF
