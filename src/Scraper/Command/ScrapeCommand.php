<?php

namespace Scraper\Command;
require_once __DIR__ . '/../Opener/ResourceOpener.php';
require_once __DIR__ . '/../Parser/GroceryParser.php';
use PHPHtmlParser\Dom;
use Scraper\Opener\ResourceOpener;
use Scraper\Parser\GroceryParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('scraper')
                ->setDescription("Sainsbury's grocery scraper");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true';
        $resource_opener = new ResourceOpener($url);

        $grocery_parser = new GroceryParser($resource_opener->open());
        $output->write(json_encode($grocery_parser->parse()));
    }
}

