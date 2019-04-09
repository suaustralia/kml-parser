<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

class Point extends Entity
{
	public function getCoordinate(): Coordinate
	{
		return new Coordinate($this->element->getChild('coordinates')->getValue());
	}
}
