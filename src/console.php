#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Scraper/Command/ScrapeCommand.php';

use Scraper\Command;
use Symfony\Component\Console\Application;

$application = new Application("Sainsbury's scraper by Laszlo", '1.0.0');
$application->add(new Command\ScrapeCommand());
$application->run();