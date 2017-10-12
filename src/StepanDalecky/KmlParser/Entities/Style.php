<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

class Style extends Entity
{

	public function getId(): string
	{
		return $this->element->getAttribute('id');
	}

	public function getIconStyle(): IconStyle
	{
		return new IconStyle($this->element->getChild('IconStyle'));
	}

	public function getLabelStyle(): LabelStyle
	{
		return new LabelStyle($this->element->getChild('LabelStyle'));
	}
}
