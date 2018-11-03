<?php
declare(strict_types=1);

namespace StepanDaleckyTests\KmlParser;

use PHPUnit\Framework\TestCase;
use StepanDalecky\KmlParser\Parser;

class ParserTest extends TestCase
{

	public function testCase1()
	{
		$file = $this->getAssetsFile('case1.kml');

		$parser = Parser::fromFile($file);

		$kml = $parser->getKml();

		$document = $kml->getDocument();
		self::assertSame('Document name', $document->getName());
		self::assertSame('Description', $document->getDescription());
		self::assertFalse($document->hasId());

		$styles = $document->getStyles();
		self::assertCount(2, $styles);

		$style1 = $styles[0];
		self::assertSame('icon-1899-0288D1-normal', $style1->getId());

		$iconStyle = $style1->getIconStyle();
		self::assertSame('ffd18802', $iconStyle->getColor());
		self::assertSame('1', $iconStyle->getScale());

		$icon = $iconStyle->getIcon();
		self::assertSame('http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png', $icon->getHref());

		$hotSpot = $iconStyle->getHotSpot();
		self::assertSame('16', $hotSpot->getX());
		self::assertSame('pixels', $hotSpot->getXunits());
		self::assertSame('32', $hotSpot->getY());
		self::assertSame('insetPixels', $hotSpot->getYunits());

		$labelStyle = $style1->getLabelStyle();
		self::assertSame('0', $labelStyle->getScale());

		$styleMap = $document->getStyleMap();

		$pairs = $styleMap->getPairs();
		self::assertCount(2, $pairs);

		$pair2 = $pairs[1];
		self::assertSame('highlight', $pair2->getKey());
		self::assertSame('#icon-1899-0288D1-highlight', $pair2->getStyleUrl());

		$folders = $document->getFolders();
		self::assertCount(2, $folders);

		$folder1 = $folders[0];
		self::assertSame('Unnamed layer', $folder1->getName());

		$placemarks = $folder1->getPlacemarks();
		self::assertCount(2, $placemarks);

		$placemark1 = $placemarks[0];
		self::assertSame('First spot name', $placemark1->getName());
		self::assertSame('First spot description', $placemark1->getDescription());
		self::assertTrue($placemark1->hasDescription());
		self::assertSame('#icon-1899-0288D1', $placemark1->getStyleUrl());

		$placemark2 = $placemarks[1];
		self::assertFalse($placemark2->hasDescription());

		$point = $placemark1->getPoint();
		self::assertSame('
            14.4420491,50.0643445,0
          ', $point->getCoordinates());

		$folder2 = $folders[1];
		self::assertSame('Empty layer', $folder2->getName());
	}

	public function testCase2()
	{
		$file = $this->getAssetsFile('case2.kml');

		$parser = Parser::fromFile($file);

		$kml = $parser->getKml();

		$document = $kml->getDocument();
		self::assertTrue($document->hasId());
		self::assertSame('root_doc', $document->getId());
		self::assertTrue($document->hasSchema());
		self::assertFalse($document->hasStyleMap());
		self::assertFalse($document->hasDescription());
		self::assertFalse($document->hasName());

		$schema = $document->getSchema();
		self::assertSame('Jalan Kabupaten Kec Parindu', $schema->getName());
		self::assertSame('Jalan_Kabupaten_Kec_johndoe', $schema->getId());

		$simpleFields = $schema->getSimpleFields();
		self::assertCount(3, $simpleFields);
		$simpleField3 = $simpleFields[2];
		self::assertSame('Panjang', $simpleField3->getName());
		self::assertSame('float', $simpleField3->getType());

		$placemark = $document->getFolders()[0]->getPlacemarks()[0];
		self::assertTrue($placemark->hasStyle());
		self::assertTrue($placemark->hasExtendedData());
		self::assertFalse($placemark->hasDescription());
		self::assertFalse($placemark->hasPoint());
		self::assertFalse($placemark->hasStyleUrl());

		$style = $placemark->getStyle();
		self::assertTrue($style->hasLineStyle());
		self::assertTrue($style->hasPolyStyle());
		self::assertFalse($style->hasId());
		self::assertFalse($style->hasIconStyle());
		self::assertFalse($style->hasLabelStyle());

		$lineStyle = $style->getLineStyle();
		self::assertSame('ff0000ff', $lineStyle->getColor());

		$polyStyle = $style->getPolyStyle();
		self::assertSame('0', $polyStyle->getFill());

		$extendedData = $placemark->getExtendedData();
		self::assertTrue($extendedData->hasSchemaData());

		$schemaData = $extendedData->getSchemaData();
		self::assertSame('#Jalan_Kabupaten_Kec_johndoe', $schemaData->getSchemaUrl());

		$simpleData = $schemaData->getSimpleData();
		self::assertCount(3, $simpleData);
		$simpleData3 = $simpleData[2];
		self::assertSame('Panjang', $simpleData3->getName());
		self::assertSame('8.78400000000', $simpleData3->getValue());
	}

	private function getAssetsFile(string $name): string
	{
		return __DIR__ . '/../../assets/' . $name;
	}
}
