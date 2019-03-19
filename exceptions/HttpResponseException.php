<?php
namespace packages\OSRM;

class HttpResponseException extends Exception {
	protected $response;
	public function __construct(string $message, $response = null) {
		parent::__construct($message);
		$this->response = $response;
	}
	public function getResponse() {
		return $this->response;
	}
}
