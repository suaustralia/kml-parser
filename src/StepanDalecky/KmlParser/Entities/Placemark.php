<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

class Placemark extends Entity
{

	public function getName(): string
	{
		return $this->element->getChild('name')->getValue();
	}

	public function getDescription(): string
	{
		return $this->element->getChild('description')->getValue();
	}

	public function getStyleUrl(): string
	{
		return $this->element->getChild('styleUrl')->getValue();
	}

	public function getPoint(): Point
	{
		return new Point($this->element->getChild('Point'));
	}
}
