<?php
namespace packages\OSRM;

/**
 * An intersection gives a full representation of any cross-way the path passes bay.
 * For every step, the very first intersection (intersections[0]) corresponds to the location of the StepManeuver. 
 * Further intersections are listed for every cross-way until the next turn instruction.
 */
class Intersection implements \JsonSerializable {

	/**
	 * Construct a Intersection object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return Intersection
	 */
	public static function fromArray(array $data): Intersection {
		$intersection = new Intersection($data['location'], $data['bearings'], $data['entry']);
		if (isset($data['classes'])) {
			$intersection->classes = $data['classes'];
		}
		if (isset($data['in'])) {
			$intersection->in = $data['in'];
		}
		if (isset($data['out'])) {
			$intersection->out = $data['out'];
		}
		if (isset($data['lanes'])) {
			$intersection->lanes = array_map(function ($lane) {
				return Lane::fromArray($lane);
			}, $data['lanes']);
		}
		return $intersection;
	}

	/** @var float[] A [longitude, latitude] pair describing the location of the turn. */
	protected $location;

	/** @var int[] A list of bearing values (e.g. [0,90,180,270]) that are available at the intersection. The bearings describe all available roads at the intersection. Values are between 0-359 (0=true north) */
	protected $bearings;

	/** @var string[]|null An array of strings signifying the classes (as specified in the profile) of the road exiting the intersection. */
	protected $classes;

	/** @var bool[] A list of entry flags, corresponding in a 1:1 relationship to the bearings.
	 * 				A value of true indicates that the respective road could be entered on a valid route. false indicates that the turn onto the respective road would violate a restriction.
	 */
	protected $entry;

	/** @var int|null index into bearings/entry array. Used to calculate the bearing just before the turn.
	 * 			 Namely, the clockwise angle from true north to the direction of travel immediately before the maneuver/passing the intersection.
	 * 			 Bearings are given relative to the intersection. 
	 * 			 To get the bearing in the direction of driving, the bearing has to be rotated by a value of 180.
	 * 			 The value is not supplied for depart maneuvers.
	 */
	protected $in;

	/**
	 * @var int|null index into the bearings/entry array.
	 * 			Used to extract the bearing just after the turn.
	 * 			Namely, The clockwise angle from true north to the direction of travel immediately after the maneuver/passing the intersection.
	 * 			The value is not supplied for arrive maneuvers.
	 */
	protected $out;

	/** @var Lane[]|null Array of Lane objects that denote the available turn lanes at the intersection. If no lane information is available for an intersection, the lanes property will be null.  */
	protected $lanes;

	/**
	 * @param float[] $location
	 * @param int[] $bearings
	 * @param bool[] $entry
	 */
	public function __construct(array $location, array $bearings, array $entry) {
		$this->location = $location;
		$this->bearings = $bearings;
		$this->entry = $entry;
	}

	/**
	 * Get the value of location
	 * 
	 * @return float[] A [longitude, latitude] pair describing the location of the turn.
	 */ 
	public function getLocation(): array {
		return $this->location;
	}

	/**
	 * Set the value of location
	 *
	 * @param float[] A [longitude, latitude] pair describing the location of the turn.
	 * @return void
	 */ 
	public function setLocation(array $location): void {
		$this->location = $location;
	}

	/**
	 * Get the list of bearing values (e.g. [0,90,180,270]) that are available at the intersection. The bearings describe all available roads at the intersection.
	 * 
	 * @return int[] Values are between 0-359 (0=true north)
	 */ 
	public function getBearings(): array {
		return $this->bearings;
	}

	/**
	 * Set the value of bearings
	 *
	 * @param int[] $bearings
	 * @return void
	 */ 
	public function setBearings(array $bearings): void {
		$this->bearings = $bearings;
	}

	/**
	 * Get the array of strings signifying the classes (as specified in the profile) of the road exiting the intersection.
	 * 
	 * @return string[]|null
	 */ 
	public function getClasses(): ?array {
		return $this->classes;
	}

	/**
	 * Set the array of strings signifying the classes (as specified in the profile) of the road exiting the intersection.
	 *
	 * @param string[]|null $classes
	 * @return  self
	 */ 
	public function setClasses(?array $classes): void {
		$this->classes = $classes;
	}

	/**
	 * Get the list of entry flags, corresponding in a 1:1 relationship to the bearings.
	 * 
	 * @return bool[]
	 */ 
	public function getEntry(): array {
		return $this->entry;
	}

	/**
	 * Set the list of entry flags, corresponding in a 1:1 relationship to the bearings.
	 *
	 * @param bool[]
	 * @return void
	 */ 
	public function setEntry(array $entry): void {
		$this->entry = $entry;
	}

	/**
	 * Get the value of in
	 * 
	 * @return int|null
	 */ 
	public function getIn(): ?int {
		return $this->in;
	}

	/**
	 * Set the value of ins
	 *
	 * @param int|null $in
	 * @return void
	 */ 
	public function setIn(?int $in): void {
		$this->in = $in;
	}

	/**
	 * Get the index into the bearings/entry array.
	 *
	 * @return int|null
	 */ 
	public function getOut(): ?int {
		return $this->out;
	}

	/**
	 * Set the index into the bearings/entry array.
	 *
	 * @param int|null  $out index into the bearings/entry array.
	 * @return void
	 */ 
	public function setOut(?int $out): void {
		$this->out = $out;
	}

	/**
	 * Get the value of lanes
	 * 
	 * @return Lane[]|null
	 */ 
	public function getLanes(): ?array {
		return $this->lanes;
	}

	/**
	 * Set the value of lanes
	 *
	 * @param Lane[]|null
	 * @return void
	 */ 
	public function setLanes(?array $lanes): void {
		$this->lanes = $lanes;
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
