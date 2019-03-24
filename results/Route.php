<?php
namespace packages\OSRM;

/**
 * Represents a route through (potentially multiple) waypoints.
 */
class Route implements \JsonSerializable {
	
	/**
	 * Construct a Route object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return Route
	 */
	public static function fromArray(array $data): Route {
		$data['legs'] = array_map(function($leg){
			return RouteLeg::fromArray($leg);
		}, $data['legs']);
		$route = new Route($data['distance'], $data['duration'], $data['weight'], $data['weight_name'], $data['legs']);
		if (isset($data['geometry'])) {
			$route->geometry = $data['geometry'];
		}
		return $route;
	}

	/** @var float The distance traveled by the route, in meters. */
	protected $distance;

	/** @var float The estimated travel time, in float number of seconds. */
	protected $duration;

	/** @var array */
	protected $geometry;

	/** @var float The calculated weight of the route. */
	protected $weight;

	/** @var string The name of the weight profile used during extraction phase. */
	protected $weightName;

	/** @var RouteLeg[] The legs between the given waypoints. */
	protected $legs;

	public function __construct(float $distance, float $duration, float $weight, string $weightName, array $legs) {
		$this->distance = $distance;
		$this->duration = $duration;
		$this->weight = $weight;
		$this->weightName = $weightName;
		$this->legs = $legs;
	}

	/**
	 * Get the distance traveled by the route, in meters.
	 * 
	 * @return float
	 */ 
	public function getDistance(): float {
		return $this->distance;
	}

	/**
	 * Set the distance traveled by the route, in meters.
	 *
	 * @param float $distance
	 * @return void
	 */ 
	public function setDistance(float $distance): void {
		$this->distance = $distance;
	}

	/**
	 * Get the estimated travel time, in float number of seconds.
	 * 
	 * @return float
	 */ 
	public function getDuration(): float {
		return $this->duration;
	}

	/**
	 * Set the estimated travel time, in float number of seconds.
	 *
	 * @param float $duration
	 * @return void
	 */ 
	public function setDuration(float $duration): void {
		$this->duration = $duration;
	}

	/**
	 * Get the value of geometry
	 * 
	 * @return mixed
	 */ 
	public function getGeometry() {
		return $this->geometry;
	}

	/**
	 * Set the value of geometry
	 *
	 * @param mixed $geometry
	 * @return void
	 */ 
	public function setGeometry($geometry): void {
		$this->geometry = $geometry;
	}

	/**
	 * Get calculated weight of the route.
	 * 
	 * @return float
	 */ 
	public function getWeight(): float {
		return $this->weight;
	}

	/**
	 * Set calculated weight of the route.
	 *
	 * @return void
	 */ 
	public function setWeight(float $weight): void {
		$this->weight = $weight;
	}

	/**
	 * Get the name of the weight profile used during extraction phase.
	 * 
	 * @return string
	 */ 
	public function getWeightName(): string {
		return $this->weightName;
	}

	/**
	 * Set the name of the weight profile used during extraction phase.
	 *
	 * @param string $weightName
	 * @return void
	 */ 
	public function setWeightName(string $weightName): void {
		$this->weightName = $weightName;
	}

	/**
	 * Get the legs between the given waypoints.
	 * 
	 * @return RouteLeg[]
	 */ 
	public function getLegs(): array {
		return $this->legs;
	}

	/**
	 * Set the legs between the given waypoints.
	 *
	 * @param RouteLeg[] $legs
	 * @return void
	 */ 
	public function setLegs(array $legs): void {
		$this->legs = $legs;
	}

	/**
	 * Make json serializable.
	 * 
	 * @return mixed
	 */
	public function jsonSerialize() {
		return get_object_vars($this);
	}
}
