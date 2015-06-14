<?php
namespace Scraper\Parser;
require_once __DIR__ . '/../Opener/ResourceOpener.php';
use PHPHtmlParser\Dom;
use Scraper\Opener\ResourceOpener;

class GroceryParser
{
    private $dom;

    public function __construct($response)
    {

        $this->dom = new Dom;
        $this->dom->load($response, []);
    }

    public function getProducts()
    {
        return $this->dom->find('div.product');
    }

    public function getProductTitle($product)
    {
        return html_entity_decode(trim($product->find('h3 a')->text));
    }

    public function getProductPrice($product)
    {
        preg_match('!\d+\.*\d*!', $product->find('p.pricePerUnit')->text, $match);
        return number_format((float)$match[0], 2, '.', '');
    }

    public function getProductLink($product)
    {
        return $product->find('h3 a')->getAttribute('href');
    }


    public function formatFileSize($number)
    {
        foreach (array('b', 'kb', 'mb', 'gb', 'tb', 'pb', 'eb') as $unit) {
            if (abs($number) < 1024) {
                return sprintf("%3.1f%s", $number, $unit);
            }
            $number /= 1024;
        }
        return sprintf("%.1f%s", $number, 'eb');
    }

    public function parse()
    {
        $retval['total'] = 0;
        foreach ($this->getProducts() as $product) {
            $resource_opener = new ResourceOpener($this->getProductLink($product));
            $response = $resource_opener->open();
            $product_description_parser = new ProductDescriptionParser($response);
            $product_details = array(
                'title' => $this->getProductTitle($product),
                'unit_price' => $this->getProductPrice($product),
                'description' => $product_description_parser->getDescription(),
                'size' => $this->formatFileSize(strlen($response)),
            );
            $retval['results'][] = $product_details;
            $retval['total'] += $product_details['unit_price'];
        }
        return $retval;
    }
}