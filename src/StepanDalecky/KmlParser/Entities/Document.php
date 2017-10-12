<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser\Entities;

use StepanDalecky\KmlParser\Element;

class Document extends Entity
{

	public function getName(): string
	{
		return $this->element->getChild('name')->getValue();
	}

	public function getDescription(): string
	{
		return $this->element->getChild('description')->getValue();
	}

	/**
	 * @return Style[]
	 */
	public function getStyles(): array
	{
		return array_map(function (Element $element) {
			return new Style($element);
		}, $this->element->getChildren('Style'));
	}

	public function getStyleMap(): StyleMap
	{
		return new StyleMap($this->element->getChild('StyleMap'));
	}

	/**
	 * @return Folder[]
	 */
	public function getFolders(): array
	{
		return array_map(function (Element $element) {
			return new Folder($element);
		}, $this->element->getChildren('Folder'));
	}
}
