<?php
require_once __DIR__ . '/../src/Scraper/Opener/ResourceOpener.php';
require_once __DIR__ . '/../src/Scraper/Parser/GroceryParser.php';
use Scraper\Opener\ResourceOpener;
use Scraper\Parser\GroceryParser;

class GroceryParserTest extends PHPUnit_Framework_TestCase
{
    private $parser;
    private $products;
    private $opener;

    public function setUp()
    {
        $file = realpath(__DIR__ . '/test_data/sains1.html');
        $this->opener = new ResourceOpener('file://' . $file);
        $this->parser = new GroceryParser($this->opener->open());
        $this->products = $this->parser->getProducts();
    }

    public function test_parser_finds_products()
    {
        $this->assertEquals(12, count($this->products));
    }

    public function test_get_product_titles()
    {
        $expected_titles = array(
            "Sainsbury's Apricot Ripe & Ready 320g",
            "Sainsbury's Avocado Ripe & Ready XL Loose 300g",
            "Sainsbury's Avocado, Ripe & Ready x2",
            "Sainsbury's Avocados, Ripe & Ready x4",
            "Sainsbury's Conference Pears, Ripe & Ready x4 (minimum)",
            "Sainsbury's Kiwi Fruit, Ripe & Ready x4",
            "Sainsbury's Mango, Ripe & Ready x2",
            "Sainsbury's Nectarines, Ripe & Ready x4",
            "Sainsbury's Peaches Ripe & Ready x4",
            "Sainsbury's Pears, Ripe & Ready x4 (minimum)",
            "Sainsbury's Plums Ripe & Ready x5",
            "Sainsbury's White Flesh Nectarines, Ripe & Ready x4"
        );

        foreach ($this->products as $product) {
            $parsed_titles[] = $this->parser->getProductTitle($product);
        }

        $this->assertEquals($expected_titles, $parsed_titles);
    }

    public function test_get_product_links()
    {
        $expected_links = array(
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-apricot-ripe---ready-320g",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado-xl-pinkerton-loose-300g",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocado--ripe---ready-x2",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-avocados--ripe---ready-x4",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-kiwi-fruit--ripe---ready-x4",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-mango--ripe---ready-x2",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-nectarines--ripe---ready-x4",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-peaches-ripe---ready-x4",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-pears--ripe---ready-x4-%28minimum%29",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-plums--firm---sweet-x4-%28minimum%29",
            "http://www.sainsburys.co.uk/shop/gb/groceries/ripe---ready/sainsburys-white-flesh-nectarines--ripe---ready-x4"
        );

        foreach ($this->products as $product) {
            $parsed_links[] = $this->parser->getProductLink($product);
        }

        $this->assertEquals($expected_links, $parsed_links);
    }

    public function test_get_product_prices()
    {
        $expected_prices = array(3.0, 1.5, 1.8, 3.2, 2.0, 1.8, 2.0, 2.0, 2.0, 2.0, 2.5, 2.0);

        foreach ($this->products as $product) {
            $parsed_prices[] = $this->parser->getProductPrice($product);
        }

        $this->assertEquals($expected_prices, $parsed_prices);
    }

    public function test_file_size_formatter()
    {
        $expected_file_sizers = array(
            '1.0b', '1.5b', '1.0kb', '1.5kb', '1.0mb', '1.5mb', '1.0gb', '1.5gb', '1.0tb', '1.5tb', '1.0pb', '1.5pb'
        );
        for ($i = 1; $i < $limit = pow(1024, 6); $i *= 1024) {
            $formatted_file_sizes[] = $this->parser->formatFileSize($i);
            $formatted_file_sizes[] = $this->parser->formatFileSize($i + $i * 0.5);
        }
        $this->assertEquals($expected_file_sizers, $formatted_file_sizes);
    }
}