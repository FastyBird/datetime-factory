<?php declare(strict_types = 1);

namespace Tests\Cases\Unit;

use FastyBird\DateTimeFactory;
use Nette;
use Ninjify\Nunjuck\TestCase\BaseMockeryTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class ExtensionTest extends BaseMockeryTestCase
{

	public function testServicesRegistration(): void
	{
		$container = $this->createContainer();

		Assert::notNull($container->getByType(DateTimeFactory\SystemClock::class));
	}

	/**
	 * @return Nette\DI\Container
	 */
	protected function createContainer(): Nette\DI\Container
	{
		$rootDir = __DIR__ . '/../../..';

		$config = new Nette\Bootstrap\Configurator();
		$config->setTempDirectory(TEMP_DIR);

		$config->addStaticParameters(['container' => ['class' => 'SystemContainer_' . md5((string) time())]]);
		$config->addStaticParameters(['appDir' => $rootDir, 'wwwDir' => $rootDir]);

		DateTimeFactory\DI\DateTimeFactoryExtension::register($config);

		return $config->createContainer();
	}

}

$test_case = new ExtensionTest();
$test_case->run();
