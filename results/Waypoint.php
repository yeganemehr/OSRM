<?php
namespace packages\OSRM;

/**
 * Object used to describe waypoint on a route.
 */
class Waypoint {

	/**
	 * Construct a Waypoint object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return Waypoint
	 */
	public static function fromArray(array $data): Waypoint {
		$waypoint = new Waypoint($data['name'], $data['location'], $data['hint']);
		if (isset($data['distance'])) {
			$waypoint->distance = $data['distance'];
		}
		return $waypoint;
	}

	/** @var string Name of the street the coordinate snapped to */
	protected $name;

	/** @var float[] Array that contains the [longitude, latitude] pair of the snapped coordinate */
	protected $location;

	/** @var float|null The distance, in metres, from the input coordinate to the snapped coordinate */
	protected $distance;

	/** @var string  Unique internal identifier of the segment (ephemeral, not constant over data updates) This can be used on subsequent request to significantly speed up the query and to connect multiple services.
	 * 				 E.g. you can use the hint value obtained by the nearest query as hint values for route inputs. */
	protected $hint;

	/**
	 * @param string $name
	 * @param float[] $location
	 * @param float $distance
	 * @param string $hint
	 */
	public function __construct(string $name, array $location, string $hint) {
		$this->name = $name;
		$this->location = $location;
		$this->hint = $hint;
	}

	/**
	 * Get the name of the street the coordinate snapped to
	 * 
	 * @return string
	 */ 
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Set the name of the street the coordinate snapped to
	 *
	 * @param string $name
	 * @return void
	 */ 
	public function setName(string $name): void {
		$this->name = $name;
	}

	/**
	 * Get the value of location
	 * 
	 * @return float[] Array that contains the [longitude, latitude] pair of the snapped coordinate
	 */ 
	public function getLocation(): array {
		return $this->location;
	}

	/**
	 * Set the value of location
	 *
	 * @param float[] $location Array that contains the [longitude, latitude] pair of the snapped coordinate
	 * @return void
	 */ 
	public function setLocation(array $location): void {
		$this->location = $location;
	}

	/**
	 * Get the distance, in metres, from the input coordinate to the snapped coordinate
	 */ 
	public function getDistance(): float {
		return $this->distance;
	}

	/**
	 * Set the distance, in metres, from the input coordinate to the snapped coordinate
	 *
	 * @param float $distance
	 * @return void
	 */ 
	public function setDistance(float $distance): void {
		$this->distance = $distance;
	}

	/**
	 * Get the unique internal identifier of the segment.
	 */ 
	public function getHint(): string {
		return $this->hint;
	}

	/**
	 * Set the unique internal identifier of the segment.
	 *
	 * @param string $hint
	 * @return void
	 */ 
	public function setHint(string $hint): void {
		$this->hint = $hint;
	}
}
