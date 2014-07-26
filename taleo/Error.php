<?php

namespace RyanSechrest\Taleo;

/**
 * Error.php
 *
 * Object for Taleo API error responses.
 *
 * @author Ryan Sechrest
 * @version 1.0.0
 */
class Error
{
	/**
	 * Taleo error code
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var int
	 */
	private $code = 0;

	/**
	 * Taleo error detail
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $detail = '';

	/**
	 * Taleo error message
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $message = '';

	/**
	 * Request
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var array
	 */
	private $request = array();

	/**
	 * Taleo error type
	 *
	 * @access private
	 * @author Ryan Sechrest
	 * @var string
	 */
	private $type = '';

	/*************************************************************************/

	/**
	 * Default constructor
	 *
	 * @access public
	 * @author Ryan Sechrest
	 * @param string $type Type
	 * @param string $message Message
	 * @param string $detail Detail
	 * @param string $code Code
	 */
	public function __construct(
		$request = array(),
		$message = '',
		$type = '',
		$code = 0,
		$detail = ''
	) {
		$this->code = $code;
		$this->detail = $detail;
		$this->message = $message;
		$this->request = $request;
		$this->type = $type;
	}

	/*************************************************************************/

	public function get_code() {
		return $this->code;
	}

	public function set_code($code) {
		$this->code = $code;
	}

	public function get_detail() {
		return $this->detail;
	}

	public function set_detail($detail) {
		$this->detail = $detail;
	}

	public function get_message() {
		return $this->message;
	}

	public function set_message($message) {
		$this->message = $message;
	}

	public function get_request() {
		return $this->request;
	}

	public function set_request($request) {
		$this->request = $request;
	}

	public function get_type() {
		return $this->type;
	}

	public function set_type($type) {
		$this->type = $type;
	}
}

// EOF
