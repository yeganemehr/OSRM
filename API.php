<?php
namespace packages\OSRM;

class API {
	/** @var string HTTP address */
	protected $gateway = 'https://router.project-osrm.org';

	public function routing(string $profile, array $coordinates) {
		return new Routing($this, $profile, $coordinates);
	}

	/**
	 * Get the value of gateway
	 * 
	 * @return string
	 */ 
	public function getGateway(): string {
		return $this->gateway;
	}

	/**
	 * Set the value of gateway
	 *
	 * @param string $gateway
	 * @return void
	 */ 
	public function setGateway(string $gateway): void {
		$this->gateway = $gateway;
	}
}
