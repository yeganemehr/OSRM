<?php
namespace packages\OSRM;

/**
 * Annotation of the whole route leg with fine-grained information about each segment or node id.
 */
class Annotation implements \JsonSerializable {

	/**
	 * Construct a Annotation object from array
	 * 
	 * @param array $data
	 * @throws packages\OSRM\Exception
	 * @return Annotation
	 */
	public static function fromArray(array $data): Annotation {
		$annotation = new Annotation($data['distance'], $data['duration'], $data['datasources'], $data['nodes'], $data['weight']);
		if (isset($data['speed'])) {
			$annotation->speed = $data['speed'];
		}
		if (isset($data['metadata'])) {
			$annotation->metadata = $data['metadata'];
		}
		return $annotation;
	}


	/** @var int[] The distance, in metres, between each pair of coordinates */
	protected $distance;

	/** @var int[] The duration between each pair of coordinates, in seconds. Does not include the duration of any turns. */
	protected $duration;

	/** @var int[] The index of the datasource for the speed between each pair of coordinates. 0 is the default profile, other values are supplied via --segment-speed-file to osrm-contract or osrm-customize. */
	protected $datasources;

	/** @var int[] The OSM node ID for each coordinate along the route, excluding the first/last user-supplied coordinates. */
	protected $nodes;

	/** @var int[] The weights between each pair of coordinates. Does not include any turn costs. */
	protected $weight;

	/** @var int Convenience field, calculation of distance / duration rounded to one decimal place. */
	protected $speed;

	/** @var mixed Metadata related to other annotations */
	protected $metadata;

	/**
	 * @param int[] $distance
	 * @param int[] $duration
	 * @param int[] $datasources
	 * @param int[] $nodes
	 * @param int[] $weight
	 */
	public function __construct(array $distance, array $duration, array $datasources, array $nodes, array $weight) {
		$this->distance = $distance;
		$this->duration = $duration;
		$this->datasources = $datasources;
		$this->nodes = $nodes;
		$this->weight = $weight;
	}

	/**
	 * Get the distance, in metres, between each pair of coordinates.
	 * 
	 * @return int[]
	 */ 
	public function getDistance(): array {
		return $this->distance;
	}

	/**
	 * Set the distance, in metres, between each pair of coordinates.
	 * 
	 * @param int[] 
	 * @return void
	 */ 
	public function setDistance(array $distance): void {
		$this->distance = $distance;
	}

	/**
	 * Get the duration between each pair of coordinates, in seconds. Does not include the duration of any turns.
	 * 
	 * @return int[]
	 */ 
	public function getDuration(): array {
		return $this->duration;
	}

	/**
	 * Set the duration between each pair of coordinates, in seconds. Does not include the duration of any turns.
	 *
	 * @param int[] $duration
	 * @return void
	 */ 
	public function setDuration(array $duration): void {
		$this->duration = $duration;
	}

	/**
	 * Get the index of the datasource for the speed between each pair of coordinates.
	 * 
	 * @return int[]
	 */ 
	public function getDatasources(): array {
		return $this->datasources;
	}

	/**
	 * Set the index of the datasource for the speed between each pair of coordinates.
	 *
	 * @param int[] $datasources
	 * @return void
	 */ 
	public function setDatasources(array $datasources): void {
		$this->datasources = $datasources;
	}

	/**
	 * Get the OSM node ID for each coordinate along the route, excluding the first/last user-supplied coordinates.
	 * 
	 * @return int[]
	 */ 
	public function getNodes(): array {
		return $this->nodes;
	}

	/**
	 * Set the OSM node ID for each coordinate along the route, excluding the first/last user-supplied coordinates.
	 *
	 * @param int[] $nodes
	 * @return void
	 */ 
	public function setNodes(array $nodes): void {
		$this->nodes = $nodes;
	}

	/**
	 * Get the weights between each pair of coordinates. Does not include any turn costs.
	 * 
	 * @return int[]
	 */ 
	public function getWeight(): array {
		return $this->weight;
	}

	/**
	 * Set the weights between each pair of coordinates. Does not include any turn costs.
	 *
	 * @param int[]
	 * @return void
	 */ 
	public function setWeight(array $weight): void {
		$this->weight = $weight;
	}

	/**
	 * Get the value of speed
	 * 
	 * @return int|null
	 */ 
	public function getSpeed(): ?int {
		return $this->speed;
	}

	/**
	 * Set the value of speed
	 *
	 * @param int|null
	 * @return void
	 */ 
	public function setSpeed(?int $speed): void	{
		$this->speed = $speed;
	}

	/**
	 * Get the value of metadata
	 * 
	 * @return mixed
	 */ 
	public function getMetadata() {
		return $this->metadata;
	}

	/**
	 * Set the value of metadata
	 *
	 * @param mixed $metadata
	 * @return void
	 */ 
	public function setMetadata($metadata): void {
		$this->metadata = $metadata;
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
