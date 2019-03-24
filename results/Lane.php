<?php
namespace packages\OSRM;

/**
 * A Lane represents a turn lane at the corresponding turn location.
 */
class Lane implements \JsonSerializable {

	/**
	 * Construct a Lane object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return Lane
	 */
	public static function fromArray(array $data): Lane {
		return new Lane($data['indications'], $data['valid']);
	}

	/**
	 * A road can have multiple indications (e.g. an arrow pointing straight and left). The indications are given in an array, each containing one of the following types.
	 * value 		Description
	 * none 		No dedicated indication is shown.
	 * uturn 		An indication signaling the possibility to reverse (i.e. fully bend arrow).
	 * sharp right 	An indication indicating a sharp right turn (i.e. strongly bend arrow).
	 * right 		An indication indicating a right turn (i.e. bend arrow).
	 * slight right An indication indicating a slight right turn (i.e. slightly bend arrow).
	 * straight 	No dedicated indication is shown (i.e. straight arrow).
	 * slight left 	An indication indicating a slight left turn (i.e. slightly bend arrow).
	 * left 		An indication indicating a left turn (i.e. bend arrow).
	 * sharp left 	An indication indicating a sharp left turn (i.e. strongly bend arrow).
	 * 
	 * @var string a indication (e.g. marking on the road) specifying the turn lane.
	 */
	protected $indications;

	/** @var bool the boolean flag indicating whether the lane is a valid choice in the current maneuver */
	protected $valid;

	/**
	 * @param string $indications
	 * @param bool $valid
	 */
	public function __construct(string $indications, bool $valid) {
		$this->indications = $indications;
		$this->valid = $valid;
	}

	/**
	 * Get the indication (e.g. marking on the road) specifying the turn lane.
	 *
	 * @return string
	 */ 
	public function getIndications(): string {
		return $this->indications;
	}

	/**
	 * Set the indication (e.g. marking on the road) specifying the turn lane.
	 *
	 * @param string $indications
	 * @return void
	 */ 
	public function setIndications(string $indications): void {
		$this->indications = $indications;
	}

	/**
	 * Get the value of valid
	 */ 
	public function getValid(): bool {
		return $this->valid;
	}

	/**
	 * Set the value of valid
	 *
	 * @param bool $valid
	 * @return void
	 */ 
	public function setValid(bool $valid): void {
		$this->valid = $valid;
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
