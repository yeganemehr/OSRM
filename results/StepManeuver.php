<?php
namespace packages\OSRM;

class StepManeuver {

	/**
	 * Construct a StepManeuver object from array
	 * 
	 * @param array $data
	 * @return Route
	 */
	public static function fromArray(array $data): StepManeuver {
		$maneuver = new StepManeuver($data['location'], $data['bearing_before'], $data['bearing_after'], $data['type']);
		if (isset($data['modifier'])) {
			$maneuver->modifier = $data['modifier'];
		}
		if (isset($data['exit'])) {
			$maneuver->exit = $data['exit'];
		}
		return $maneuver;
	}

	/** @var float[] A [longitude, latitude] pair describing the location of the turn. */
	protected $location;

	/** @var int The clockwise angle from true north to the direction of travel immediately before the maneuver. Range 0-359. */
	protected $bearingBefore;

	/** @var int The clockwise angle from true north to the direction of travel immediately after the maneuver. Range 0-359. */
	protected $bearingAfter;

	/**
	 * new identifiers might be introduced without API change Types unknown to the client should be handled like the turn type,
	 * the existence of correct modifier values is guranteed.
	 * 
	 *  type 			Description
	 *	turn 			a basic turn into direction of the modifier
	 *	new name 		no turn is taken/possible, but the road name changes. The road can take a turn itself, following modifier .
	 *	depart 			indicates the departure of the leg
	 *	arrive 			indicates the destination of the leg
	 *	merge 			merge onto a street (e.g. getting on the highway from a ramp, the modifier specifies the direction of the merge )
	 *	ramp 			Deprecated . Replaced by on_ramp and off_ramp .
	 *	on ramp 		take a ramp to enter a highway (direction given my modifier )
	 *	off ramp 		take a ramp to exit a highway (direction given my modifier )
	 *	fork 			take the left/right side at a fork depending on modifier
	 *	end of road 	road ends in a T intersection turn in direction of modifier
	 *	use lane 		Deprecated replaced by lanes on all intersection entries
	 *	continue 		Turn in direction of modifier to stay on the same road
	 *	roundabout 		traverse roundabout, if the route leaves the roundabout there will be an additional property exit for exit counting. The modifier specifies the direction of entering the roundabout.
	 *	rotary 			a traffic circle. While very similar to a larger version of a roundabout, it does not necessarily follow roundabout rules for right of way. It can offer rotary_name and/or rotary_pronunciation parameters (located in the RouteStep object) in addition to the exit parameter (located on the StepManeuver object).
	 *	roundabout turn Describes a turn at a small roundabout that should be treated as normal turn. The modifier indicates the turn direciton. Example instruction: At the roundabout turn left .
	 *	notification 	not an actual turn but a change in the driving conditions. For example the travel mode or classes. If the road takes a turn itself, the modifier describes the direction
	 *	exit roundabout Describes a maneuver exiting a roundabout (usually preceeded by a roundabout instruction)
	 *	exit rotary 	Describes the maneuver exiting a rotary (large named roundabout)
	 * @var string type A string indicating the type of maneuver.
	 */
	protected $type;

	/**
	 * modifier 	Description
	 * uturn 		indicates reversal of direction
	 * sharp right 	a sharp right turn
	 * right 		a normal turn to the right
	 * slight right a slight turn to the right
	 * straight 	no relevant change in direction
	 * slight left 	a slight turn to the left
	 * left 		a normal turn to the left
	 * sharp left 	a sharp turn to the left
	 * 
	 * @var string|null An optional string indicating the direction change of the maneuver.
	 */
	protected $modifier;

	/**
	 * he property exists for the roundabout / rotary property: Number of the roundabout exit to take. If exit is null the destination is on the roundabout.
	 * 
	 * @var int|null An optional integer indicating number of the exit to take. 
	 */
	protected $exit;

	/**
	 * @param float[] $location
	 * @param int $bearingBefore
	 * @param int $bearingAfter
	 * @param string $type
	 */
	public function __construct(array $location, int $bearingBefore, int $bearingAfter, string $type) {
		$this->location = $location;
		$this->bearingBefore = $bearingBefore;
		$this->bearingAfter = $bearingAfter;
		$this->type = $type;
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
	 * @param float[] $location A [longitude, latitude] pair describing the location of the turn.
	 * @return void
	 */ 
	public function setLocation(array $location): void {
		$this->location = $location;
	}

	/**
	 * Get the clockwise angle from true north to the direction of travel immediately before the maneuver.
	 * 
	 * @return int Range 0-359.
	 */ 
	public function getBearingBefore(): int {
		return $this->bearingBefore;
	}

	/**
	 * Set the clockwise angle from true north to the direction of travel immediately before the maneuver.
	 *
	 * @param int $bearingBefore Range 0-359.
	 * @return void
	 */ 
	public function setBearingBefore(int $bearingBefore): void {
		$this->bearingBefore = $bearingBefore;
	}

	/**
	 * Get the clockwise angle from true north to the direction of travel immediately after the maneuver.
	 * 
	 * @return int Range 0-359.
	 */ 
	public function getBearingAfter(): int {
		return $this->bearingAfter;
	}

	/**
	 * Set the clockwise angle from true north to the direction of travel immediately after the maneuver.
	 *
	 * @param int $bearingAfter Range 0-359.
	 * @return void
	 */ 
	public function setBearingAfter(int $bearingAfter): void {
		$this->bearingAfter = $bearingAfter;
	}

	/**
	 * Get the type of maneuver.
	 *
	 * @return  string
	 */ 
	public function getType(): string {
		return $this->type;
	}

	/**
	 * Set the type of maneuver.
	 *
	 * @param string $type 
	 * @return void
	 */ 
	public function setType(string $type): void {
		$this->type = $type;
	}

	/**
	 * Get the direction change of the maneuver.
	 *
	 * @return string|null
	 */ 
	public function getModifier(): ?string {
		return $this->modifier;
	}

	/**
	 * Set the direction change of the maneuver.
	 *
	 * @param string|null $modifier
	 * @return void
	 */ 
	public function setModifier(?string $modifier): void {
		$this->modifier = $modifier;
	}

	/**
	 * Get an indicating number of the exit to take.
	 *
	 * @return int|null
	 */ 
	public function getExit(): ?int {
		return $this->exit;
	}

	/**
	 * Set the indicating number of the exit to take.
	 *
	 * @param int|null $exit
	 * @return void
	 */ 
	public function setExit(?int $exit): void {
		$this->exit = $exit;
	}
}
