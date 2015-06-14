<?php
namespace Scraper\Parser;

use PHPHtmlParser\Dom;

class ProductDescriptionParser
{
    private $dom;

    public function __construct($response)
    {
        $this->dom = new Dom;
        $this->dom->load($response, []);
    }

    public function getDescription()
    {
        return html_entity_decode(trim($this->dom->find('meta[name="description"]')[0]->content), ENT_QUOTES);
    }
}