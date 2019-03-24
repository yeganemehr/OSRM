<?php
namespace packages\OSRM;

/**
 * A step consists of a maneuver such as a turn or merge, followed by a distance of travel along a single way to the subsequent step.
 */
class RouteStep implements \JsonSerializable {

	/**
	 * Construct a RouteStep object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return RouteStep
	 */
	public static function fromArray(array $data): RouteStep {
		$data['maneuver'] = StepManeuver::fromArray($data['maneuver']);
		$data['intersections'] = array_map(function($intersection) {
			return Intersection::fromArray($intersection);
		}, $data['intersections']);

		$step = new RouteStep(
			$data['distance'],
			$data['duration'],
			$data['geometry'],
			$data['name'],
			$data['mode'],
			$data['maneuver'],
			$data['intersections']
		);
		if (isset($data['ref'])) {
			$step->ref = $data['ref'];
		}
		if (isset($data['pronunciation'])) {
			$step->pronunciation = $data['pronunciation'];
		}
		if (isset($data['destinations'])) {
			$step->destinations = $data['destinations'];
		}
		if (isset($data['exits'])) {
			$step->exits = $data['exits'];
		}
		if (isset($data['rotaryName'])) {
			$step->rotaryName = $data['rotaryName'];
		}
		if (isset($data['rotaryPronunciation'])) {
			$step->rotaryPronunciation = $data['rotaryPronunciation'];
		}
		if (isset($data['drivingSide'])) {
			$step->drivingSide = $data['drivingSide'];
		}
		return $step;
	}

	/** @var float The distance of travel from the maneuver to the subsequent step, in meters. */
	protected $distance;

	/** @var float The estimated travel time, in number of seconds. */
	protected $duration;

	/** @var string The unsimplified geometry of the route segment, depending on the geometries parameter. */
	protected $geometry;

	/** @var string The name of the way along which travel proceeds. */
	protected $name;

	/** @var string|null A reference number or code for the way. Optionally included, if ref data is available for the given way. */
	protected $ref;

	/** @var string|null A string containing an IPA phonetic transcription indicating how to pronounce the name in the name property.  */
	protected $pronunciation;

	/** @var mixed The destinations of the way. Will be null or undefined if there are no destinations. */
	protected $destinations;

	/** @var int|null The exit numbers or names of the way. Will be null if there are no exit numbers or names. */
	protected $exits;

	/** @var string A string signifying the mode of transportation. */
	protected $mode;

	/** @var StepManeuver A StepManeuver object representing the maneuver. */
	protected $maneuver;

	/** @var Intersection[] A list of Intersection objects that are passed along the segment, the very first belonging to the StepManeuver */
	protected $intersections;

	/** @var string|null The name for the rotary. Optionally included, if the step is a rotary and a rotary name is available. */
	protected $rotaryName;

	/** @var string|null  The pronunciation hint of the rotary name. Optionally included, if the step is a rotary and a rotary pronunciation is available. */
	protected $rotaryPronunciation;

	/** @var string|null The legal driving side at the location for this step. Either "left" or "right". */
	protected $drivingSide;

	/**
	 * @param float $distance
	 * @param float $duration
	 * @param string $geometry
	 * @param string $name
	 * @param string $mode
	 * @param StepManeuver $maneuver
	 * @param Intersection[] $intersections
	 * @param string $drivingSide
	 */
	public function __construct(
		float $distance,
		float $duration,
		string $geometry,
		string $name,
		string $mode,
		StepManeuver $maneuver,
		array $intersections
	) {
		$this->distance = $distance;
		$this->duration = $duration;
		$this->geometry = $geometry;
		$this->name = $name;
		$this->mode = $mode;
		$this->maneuver = $maneuver;
		$this->intersections = $intersections;
	}

	/**
	 * Get he distance of travel from the maneuver to the subsequent step, in meters.
	 * 
	 * @return float
	 */ 
	public function getDistance(): float {
		return $this->distance;
	}

	/**
	 * Set the distance of travel from the maneuver to the subsequent step, in meters.
	 *
	 * @param float $distance
	 * @return void
	 */ 
	public function setDistance(float $distance): void {
		$this->distance = $distance;
	}

	/**
	 * Get the estimated travel time, in number of seconds.
	 * 
	 * @return flaot
	 */ 
	public function getDuration(): float {
		return $this->duration;
	}

	/**
	 * Set the estimated travel time, in number of seconds.
	 *
	 * @param float $duration
	 * @return void
	 */ 
	public function setDuration(float $duration): void {
		$this->duration = $duration;
	}

	/**
	 * Get the unsimplified geometry of the route segment, depending on the geometries parameter.
	 * 
	 * @return string
	 */ 
	public function getGeometry(): string {
		return $this->geometry;
	}

	/**
	 * Set the unsimplified geometry of the route segment, depending on the geometries parameter.
	 *
	 * @param string $geometry
	 * @return void
	 */ 
	public function setGeometry(string $geometry): void {
		$this->geometry = $geometry;
	}

	/**
	 * Get the name of the way along which travel proceeds.
	 * 
	 * @param string
	 */ 
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Set the name of the way along which travel proceeds.
	 *
	 * @param string $name
	 * @return void
	 */ 
	public function setName(string $name): void {
		$this->name = $name;
	}

	/**
	 * Get the reference number or code for the way. Optionally included, if ref data is available for the given way.
	 * 
	 * @return string|null
	 */ 
	public function getRef(): ?string {
		return $this->ref;
	}

	/**
	 * Set the reference number or code for the way.
	 *
	 * @param string|null $ref
	 * @return void
	 */ 
	public function setRef(?string $ref): void {
		$this->ref = $ref;
	}

	/**
	 * Get the IPA phonetic transcription indicating how to pronounce the name in the name property.
	 * 
	 * @return string|null
	 */ 
	public function getPronunciation(): ?string {
		return $this->pronunciation;
	}

	/**
	 * Set the IPA phonetic transcription indicating how to pronounce the name in the name property.
	 *
	 * @param string|null $pronunciation
	 * @return void
	 */ 
	public function setPronunciation(?string $pronunciation): void {
		$this->pronunciation = $pronunciation;
	}

	/**
	 * Get the destinations of the way.
	 * 
	 * @return mixed Will be null if there are no destinations.
	 */ 
	public function getDestinations() {
		return $this->destinations;
	}

	/**
	 * Set the destinations of the way. 
	 *
	 * @param mixed $destinations null if there are no destinations.
	 * @return void
	 */ 
	public function setDestinations($destinations): void {
		$this->destinations = $destinations;
	}

	/**
	 * Get the exit numbers or names of the way. 
	 * 
	 * @return int|null Will be null if there are no exit numbers or names.
	 */ 
	public function getExits(): ?int {
		return $this->exits;
	}

	/**
	 * Set the exit numbers or names of the way.
	 *
	 * @param int|null $exits null if there are no exit numbers or names.
	 * @return void
	 */ 
	public function setExits(?int $exits): void {
		$this->exits = $exits;
	}

	/**
	 * Get the mode of transportation.
	 * 
	 * @return string
	 */ 
	public function getMode(): string {
		return $this->mode;
	}

	/**
	 * Set the mode of transportation.
	 *
	 * @param string $mode
	 * @return  self
	 */ 
	public function setMode(string $mode): void {
		$this->mode = $mode;
	}

	/**
	 * Get the StepManeuver object representing the maneuver.
	 * 
	 * @return StepManeuver
	 */ 
	public function getManeuver(): StepManeuver	{
		return $this->maneuver;
	}

	/**
	 * Set the StepManeuver object representing the maneuver.
	 *
	 * @param StepManeuver $maneuver
	 * @return void
	 */ 
	public function setManeuver(StepManeuver $maneuver): void {
		$this->maneuver = $maneuver;
	}

	/**
	 * Get the value of intersections
	 * 
	 * @return Intersection[]
	 */ 
	public function getIntersections(): array {
		return $this->intersections;
	}

	/**
	 * Set the value of intersections
	 *
	 * @param Intersection[] $intersections
	 * @return void
	 */ 
	public function setIntersections(array $intersections): void {
		$this->intersections = $intersections;
	}

	/**
	 * Get the name for the rotary.
	 * 
	 * @return string|null if the step is a rotary and a rotary name is available.
	 */ 
	public function getRotaryName(): ?string {
		return $this->rotaryName;
	}

	/**
	 * Set the name for the rotary. Optionally included.
	 *
	 * @param string|null $rotaryName
	 * @return void
	 */ 
	public function setRotaryName(?string $rotaryName): void {
		$this->rotaryName = $rotaryName;
	}

	/**
	 * Get the pronunciation hint of the rotary name.
	 * 
	 * @return string|null
	 */ 
	public function getRotaryPronunciation(): ?string {
		return $this->rotaryPronunciation;
	}

	/**
	 * Set the pronunciation hint of the rotary name.
	 *
	 * @param string|null
	 * @return void
	 */ 
	public function setRotaryPronunciation(?string $rotaryPronunciation): void {
		$this->rotaryPronunciation = $rotaryPronunciation;
	}

	/**
	 * Get legal driving side at the location for this step.
	 * 
	 * @return string|null Either "left" or "right"
	 */ 
	public function getDrivingSide(): ?string {
		return $this->drivingSide;
	}

	/**
	 * Set legal driving side at the location for this step.
	 *
	 * @param string|null $drivingSide Either "left" or "right"
	 * @return void
	 */ 
	public function setDrivingSide(?string $drivingSide): void {
		$this->drivingSide = $drivingSide;
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
