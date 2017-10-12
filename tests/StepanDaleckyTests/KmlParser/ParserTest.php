<?php
declare(strict_types=1);

namespace StepanDaleckyTests\KmlParser;

use PHPUnit\Framework\TestCase;
use StepanDalecky\KmlParser\Parser;

class ParserTest extends TestCase
{

	public function test()
	{
		$file = __DIR__ . '/../../assets/sample.kml';

		$parser = Parser::fromFile($file);

		$kml = $parser->getKml();

		$document = $kml->getDocument();
		self::assertSame('Document name', $document->getName());
		self::assertSame('Description', $document->getDescription());

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
		self::assertSame('#icon-1899-0288D1', $placemark1->getStyleUrl());

		$point = $placemark1->getPoint();
		self::assertSame('
            14.4420491,50.0643445,0
          ', $point->getCoordinates());

		$folder2 = $folders[1];
		self::assertSame('Empty layer', $folder2->getName());
	}
}
