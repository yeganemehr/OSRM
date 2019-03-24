<?php
namespace packages\OSRM;
use packages\base\{http, json};
/**
 * Finds the fastest route between coordinates in the supplied order.
 */
class Routing {
	/** @var API */
	protected $api;

	/** @var string Mode of transportation, is determined statically by the Lua profile that is used to prepare the data using osrm-extract . Typically car , bike or foot if using one of the supplied profiles. */
	protected $profile;

	/** @var float[][] */
	protected $coordinates;

	/** @var bool|int Search for alternative routes. Passing a number alternatives=n searches for up to n alternative routes. */
	protected $alternatives = false;

	/** @var bool Returned route steps for each route leg */
	protected $steps = false;

	/** @var bool|string Returns additional metadata for each coordinate along the route geometry. values: [nodes , distance , duration , datasources , weight , speed] */
	protected $annotations = false;

	/** @var string Returned route geometry format (influences overview and per step), values: [polyline, polyline6 , geojson] */
	protected $geometries = "polyline";

	/** @var false|string Add overview geometry either full, simplified according to highest zoom level it could be display on, or not at all. values: [simplified, full , false] */
	protected $overview = "simplified";

	/** @var bool|string Forces the route to keep going straight at waypoints constraining uturns there even if it would be faster. Default value depends on the profile. */
	protected $continueStraight = "default";

	/** @var mixed Treats input coordinates indicated by given indices as waypoints in returned Match object. Default is to treat all input coordinates as waypoints. */
	protected $waypoints;

	/**
	 * @param string $profile
	 * @param array $coordinates
	 */
	public function __construct(API $api, string $profile, array $coordinates) {
		$this->api = $api;
		$this->profile = $profile;
		$this->coordinates = $coordinates;
	}

	/**
	 * Get the value of profile
	 * 
	 * @return string 
	 */ 
	public function getProfile(): string {
		return $this->profile;
	}

	/**
	 * Set the value of profile
	 *
	 * @param string $profile
	 * @return void
	 */ 
	public function setProfile(string $profile): void {
		$this->profile = $profile;
	}

	/**
	 * Get the value of coordinates
	 * 
	 * @return float[][]
	 */ 
	public function getCoordinates(): array {
		return $this->coordinates;
	}

	/**
	 * Set the value of coordinates
	 * 
	 * @param float[][] $coordinates
	 * @return void
	 */ 
	public function setCoordinates(array $coordinates): void {
		$this->coordinates = $coordinates;
	}

	/**
	 * Get the value of alternatives
	 * 
	 * @return bool|int
	 */ 
	public function getAlternatives() {
		return $this->alternatives;
	}

	/**
	 * Set the value of alternatives
	 *
	 * @param bool|int $alternatives
	 * @return void
	 */ 
	public function setAlternatives($alternatives): void {
		$this->alternatives = $alternatives;
	}

	/**
	 * Get the value of steps
	 * 
	 * @return bool
	 */ 
	public function getSteps(): bool {
		return $this->steps;
	}

	/**
	 * Set the value of steps
	 *
	 * @param bool $steps
	 * @return void
	 */ 
	public function setSteps(bool $steps): void {
		$this->steps = $steps;
	}

	/**
	 * Get the value of annotations
	 * 
	 * @return bool|string values: [true, false, "nodes" , "distance" , "duration" , "datasources" , "weight" , "speed"]
	 */ 
	public function getAnnotations() {
		return $this->annotations;
	}

	/**
	 * Set the value of annotations
	 *
	 * @param bool|string $annotations values: [true, false, "nodes" , "distance" , "duration" , "datasources" , "weight" , "speed"]
	 * @return void
	 */ 
	public function setAnnotations($annotations): void {
		$this->annotations = $annotations;
	}

	/**
	 * Get the value of geometries
	 * 
	 * @return string values: polyline, polyline6 , geojso
	 */ 
	public function getGeometries(): string {
		return $this->geometries;
	}

	/**
	 * Set the value of geometries
	 *
	 * @param string $geometries values: polyline, polyline6 , geojso
	 * @return void
	 */ 
	public function setGeometries(string $geometries): void {
		$this->geometries = $geometries;
	}

	/**
	 * Get the value of overview
	 * 
	 * @return string|false values: [simplified, full , false]
	 */ 
	public function getOverview() {
		return $this->overview;
	}

	/**
	 * Set the value of overview
	 *
	 * @param string|false $overview values: [simplified, full , false]
	 * @return void
	 */ 
	public function setOverview($overview): void {
		$this->overview = $overview;
	}

	/**
	 * Get the value of continueStraight
	 * 
	 * @return bool|string values: [false, true, "default"]
	 */ 
	public function getContinueStraight() {
		return $this->continueStraight;
	}

	/**
	 * Set the value of continueStraight
	 *
	 * @param bool|string values: [false, true, "default"]
	 * @return void
	 */ 
	public function setContinueStraight($continueStraight): void {
		$this->continueStraight = $continueStraight;
	}

	/**
	 * Get the value of waypoints
	 * 
	 * @return mixed
	 */ 
	public function getWaypoints() {
		return $this->waypoints;
	}

	/**
	 * Set the value of waypoints
	 *
	 * @param mixed $waypoints
	 * @return void
	 */ 
	public function setWaypoints($waypoints): void {
		$this->waypoints = $waypoints;
	}

	/**
	 * @throws packages\base\http\responseException
	 */
	public function call() {
		$http = new http\client(array(
			'base_uri' => $this->api->getGateway(),
		));
		$query = [];
		if ($this->alternatives !== false) {
			$query['alternatives'] = json\encode($this->alternatives);
		}
		if ($this->steps) {
			$query['steps'] = "true";
		}
		if ($this->annotations !== false) {
			$query['annotations'] = $this->annotations === true ? "true" : $this->annotations;
		}
		if ($this->geometries != "polyline") {
			$query['geometries'] = $this->geometries;
		}
		if ($this->overview != "simplified") {
			$query['overview'] = is_bool($this->overview) ? json\encode($this->overview) : $this->overview;
		}
		if ($this->continueStraight !== "default") {
			$query['continue_straight'] = is_bool($this->continueStraight) ? json\encode($this->continueStraight) : $this->continueStraight;
		}
		if ($this->waypoints) {
			$query['waypoints'] = $this->waypoints;
		}
		$response = $http->get("/route/v1/" . $this->profile . "/" . $this->getStringCoordinates(), array(
			"query" => $query
		));
		$data = json\decode($response->getBody());
		if (!isset($data['code'])) {
			throw new HttpResponseException("there is no code field in response", $response);
		}
		if ($data['code'] != "Ok") {
			throw new HttpResponseException("failed code", $response);
		}
		$data['routes'] = array_map(function($route) {
			return Route::fromArray($route);
		}, $data['routes']);

		$data['waypoints'] = array_map(function($waypoint) {
			return WayPoint::fromArray($waypoint);
		}, $data['waypoints']);

		return $data;
	}

	/**
	 * @return string
	 */
	protected function getStringCoordinates(): string {
		return implode(";", array_map(function($coordinate) {
			return implode(",", $coordinate);
		}, $this->coordinates));
	}
}

