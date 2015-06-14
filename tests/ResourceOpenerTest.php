<?php
require_once __DIR__ . '/../src/Scraper/Opener/ResourceOpener.php';
use Scraper\Opener\ResourceOpener;

class ResourceOpenerTest extends PHPUnit_Framework_TestCase
{
    private $opener;
    private $file;

    public function setUp()
    {
        $this->file = realpath(__DIR__ . '/test_data/sains1.html');
        $this->opener = new ResourceOpener('file://' . $this->file);
    }

    public function test_opener_returns_contents()
    {
        $this->assertEquals(file_get_contents($this->file), $this->opener->open());
    }
}