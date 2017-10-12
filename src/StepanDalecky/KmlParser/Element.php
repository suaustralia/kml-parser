<?php
declare(strict_types = 1);

namespace StepanDalecky\KmlParser;

use StepanDalecky\KmlParser\Exceptions\UnexpectedKmlStructureException;

class Element
{

	/** @var \SimpleXMLElement */
	private $xmlElement;

	public function __construct(\SimpleXMLElement $xmlElement)
	{
		$this->xmlElement = $xmlElement;
	}

	public function getChild(string $name): self
	{
		if (!isset($this->xmlElement->{$name})) {
			throw new UnexpectedKmlStructureException(sprintf(
				'There is no <%s> element nested in <%s> element.',
				$name,
				$this->getName()
			));
		}
		if ($this->xmlElement->{$name}->count() > 1) {
			throw new UnexpectedKmlStructureException(sprintf(
				'There are more <%s> elements nested in <%s>, only one was expected.',
				$name,
				$this->getName()
			));
		}

		/** @var \SimpleXMLElement $nestedXmlElement */
		$nestedXmlElement = $this->xmlElement->{$name};

		return new self($nestedXmlElement);
	}

	/**
	 * @param string $name
	 * @return self[]
	 */
	public function getChildren(string $name): array
	{
		if (!isset($this->xmlElement->{$name})) {
			throw new UnexpectedKmlStructureException(sprintf(
				'There are no <%s> elements nested in <%s> element.',
				$name,
				$this->getName()
			));
		}

		$elements = [];
		/** @var \SimpleXMLElement $xmlElement */
		foreach ($this->xmlElement->{$name} as $xmlElement) {
			$elements[] = new self($xmlElement);
		}

		return $elements;
	}

	public function getValue(): string
	{
		return (string) $this->xmlElement;
	}

	public function getAttribute(string $name): string
	{
		if (!isset($this->xmlElement[$name])) {
			throw new UnexpectedKmlStructureException(sprintf(
				'Attribute "%s" does not exists in <%s> element.',
				$name,
				$this->getName()
			));
		}

		return (string) $this->xmlElement[$name];
	}

	/**
	 * @return string[] [<attribute name> => <attribute value>, ...]
	 */
	public function getAttributes(): array
	{
		$attributes = [];
		/**
		 * @var string $name
		 * @var \SimpleXMLElement $xmlElement
		 */
		foreach ($this->xmlElement->attributes() as $name => $xmlElement) {
			$attributes[$name] = (string) $xmlElement;
		}

		return $attributes;
	}

	private function getName(): string
	{
		return $this->xmlElement->getName();
	}
}
