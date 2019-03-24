<?php
namespace packages\OSRM;

/**
 * Represents a route between two waypoints.
 */
class RouteLeg implements \JsonSerializable {

	/**
	 * Construct a RouteLeg object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return RouteLeg
	 */
	public static function fromArray(array $data): RouteLeg {
		$leg = new RouteLeg($data['distance'], $data['duration'], $data['weight']);
		if (isset($data['steps'])) {
			$leg->steps = array_map(function($step){
				return RouteStep::fromArray($step);
			}, $data['steps']);
		}
		if (isset($data['summary'])) {
			$leg->summary = $data['summary'];
		}
		if (isset($data['annotation'])) {
			$leg->annotation = Annotation::fromArray($data['annotation']);
		}
		return $leg;
	}

	/** @var float The distance traveled by this route leg, in meters. */
	protected $distance;

	/** @var float The estimated travel time, in float number of seconds. */
	protected $duration;

	/** @var float The calculated weight of the route leg. */
	protected $weight;

	/** @var string|null Summary of the route taken as string. Depends on the `summary` parameter. */
	protected $summary;

	/** @var RouteStep[]|null Depends on the steps parameter. array of RouteStep objects describing the turn-by-turn instructions. */
	protected $steps;

	/** @var Annotation|null Additional details about each coordinate along the route geometry. */
	protected $annotation;

	/**
	 * @param float $distance
	 * @param float $duration
	 * @param float $weight
	 */
	public function __construct(float $distance, float $duration, float $weight) {
		$this->distance = $distance;
		$this->duration = $duration;
		$this->weight = $weight;
	}
	/**
	 * Get the distance traveled by this route leg, in meters.
	 * 
	 * @return float
	 */ 
	public function getDistance(): float {
		return $this->distance;
	}

	/**
	 * Set the distance traveled by this route leg, in meters.
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
	 * Set the value of duration
	 *
	 * @param float $duration
	 * @return void
	 */ 
	public function setDuration(float $duration): void {
		$this->duration = $duration;
	}

	/**
	 * Get he calculated weight of the route leg.
	 * 
	 * @return float
	 */ 
	public function getWeight(): float {
		return $this->weight;
	}

	/**
	 * Set the value of weight
	 *
	 * @param float $weight
	 * @return void
	 */ 
	public function setWeight(float $weight): void {
		$this->weight = $weight;
	}

	/**
	 * Get summary of the route taken.
	 * 
	 * @return string|null
	 */ 
	public function getSummary(): ?string {
		return $this->summary;
	}

	/**
	 * Set the summary of the route taken.
	 *
	 * @return string|null
	 */ 
	public function setSummary(?string $summary): void {
		$this->summary = $summary;
	}

	/**
	 * Get the steps which describing the turn-by-turn instructions.
	 * 
	 * @return RouteStep[]|null
	 */ 
	public function getSteps(): ?array {
		return $this->steps;
	}

	/**
	 * Set the steps which describing the turn-by-turn instructions.
	 *
	 * @param RouteStep[]|null $steps
	 * @return void
	 */ 
	public function setSteps(?array $steps): void {
		$this->steps = $steps;
	}

	/**
	 * Get the additional details about each coordinate along the route geometry.
	 * 
	 * @return Annotation|null
	 */ 
	public function getAnnotation(): ?Annotation {
		return $this->annotation;
	}

	/**
	 * Set the additional details about each coordinate along the route geometry.
	 * 
	 * @param Annotation|null
	 * @return void
	 */ 
	public function setAnnotation(?Annotation $annotation): void {
		$this->annotation = $annotation;
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
