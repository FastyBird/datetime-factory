<?php declare(strict_types = 1);

// phpcs:ignoreFile

use Ninjify\Nunjuck\Environment;

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}

// Configure environment
Environment::setupTester();
Environment::setupTimezone('UTC');
Environment::setupVariables(__DIR__);
