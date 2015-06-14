<?php
require_once __DIR__ . '/../src/Scraper/Opener/ResourceOpener.php';
require_once __DIR__ . '/../src/Scraper/Parser/ProductDescriptionParser.php';
use Scraper\Opener\ResourceOpener;
use Scraper\Parser\ProductDescriptionParser;

class ProductDescriptionParserTest extends PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $file = realpath(__DIR__ . '/test_data/sains2.html');
        $opener = new ResourceOpener('file://' . $file);
        $this->parser = new ProductDescriptionParser($opener->open());
    }

    public function test_get_description()
    {
        $expected_description = "Buy Sainsbury's Avocado Ripe & Ready XL Loose 300g online from Sainsbury's, the same great quality, freshness and choice you'd find in store. Choose from 1 hour delivery slots and collect Nectar points.";
        $this->assertEquals($expected_description, $this->parser->getDescription());
    }
}