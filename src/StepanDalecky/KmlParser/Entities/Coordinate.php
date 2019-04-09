<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

class Coordinate
{
	/** @var string */
	private $longitude;

	/** @var string */
	private $latitude;

	/** @var string */
	private $altitude;

	public function __construct($string)
	{
		$elements = explode(',', trim($string));
		if (count($elements) >= 2) {
			$this->longitude = $elements[0];
			$this->latitude = $elements[1];
		}

		if (count($elements) === 3) {
			$this->altitude = $elements[2];
		}
	}

	public function getLongitude(): string
	{
		return $this->longitude;
	}

	public function getLatitude(): string
	{
		return $this->latitude;
	}

	public function getAltitude(): string
	{
		return $this->altitude;
	}
}
