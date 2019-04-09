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
	 * @return string[]
	 */
	public function getCoordinates(): array
	{
		return array_map(
			'trim',
			explode("\n", trim($this->getLinearRing()->getChild('coordinates')->getValue()))
		);
	}

	private function getLinearRing(): Element
	{
		return $this->element->getChild('outerBoundaryIs')->getChild('LinearRing');
	}
}
