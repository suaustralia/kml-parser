<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

use StepanDalecky\XmlElement\Element;

class Polygon extends Entity
{
	public function isTessellate(): bool
	{
		return (bool)$this->getLinearRing()->getChild('tessellate')->getValue();
	}

	/**
	 * @return Coordinate[]
	 */
	public function getCoordinates(): array
	{
		$coordinates = [];
		$strings = explode("\n", trim($this->getLinearRing()->getChild('coordinates')->getValue()));
		foreach ($strings as $string) {
			$coordinates[] = new Coordinate($string);
		}

		return $coordinates;
	}

	private function getLinearRing(): Element
	{
		return $this->element->getChild('outerBoundaryIs')->getChild('LinearRing');
	}
}
