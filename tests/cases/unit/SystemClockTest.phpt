<?php declare(strict_types = 1);

namespace Tests\Cases\Unit;

use DateTimeImmutable;
use FastyBird\DateTimeFactory;
use Nette;
use Ninjify\Nunjuck\TestCase\BaseMockeryTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class SystemClockTest extends BaseMockeryTestCase
{

	public function testType(): void
	{
		$dateTimeFactory = $this->createContainer()->getByType(DateTimeFactory\Clock::class);

		$first = $dateTimeFactory->getNow();
		$second = $dateTimeFactory->getNow();

		Assert::type(DateTimeImmutable::class, $first);
		Assert::notSame($first, $second);
	}

	public function testGetNow(): void
	{
		$dateTimeFactory = $this->createContainer()->getByType(DateTimeFactory\Clock::class);

		$before = new DateTimeImmutable();
		$first = $dateTimeFactory->getNow();

		Assert::true($before <= $first);

		$after = new DateTimeImmutable();

		Assert::true($first <= $after);

		$second = $dateTimeFactory->getNow();

		Assert::true($first <= $second);
	}

	public function testTimeZone(): void
	{
		$dateTimeFactory = $this->createContainer()->getByType(DateTimeFactory\Clock::class);

		Assert::same('UTC', $dateTimeFactory->getNow()->getTimezone()->getName());

		$dateTimeFactory = $this->createContainer(__DIR__ . '/timezone.neon')
			->getByType(DateTimeFactory\Clock::class);

		Assert::same('Europe/Amsterdam', $dateTimeFactory->getNow()->getTimezone()->getName());
	}

	/**
	 * @param string|null $additionalConfig
	 *
	 * @return Nette\DI\Container
	 */
	protected function createContainer(?string $additionalConfig = null): Nette\DI\Container
	{
		$rootDir = __DIR__ . '/../../';

		$config = new Nette\Bootstrap\Configurator();
		$config->setTempDirectory(TEMP_DIR);

		$config->addStaticParameters(['container' => ['class' => 'SystemContainer_' . md5((string) time())]]);
		$config->addStaticParameters(['appDir' => $rootDir, 'wwwDir' => $rootDir]);

		if ($additionalConfig !== null && file_exists($additionalConfig)) {
			$config->addConfig($additionalConfig);
		}

		DateTimeFactory\DI\DateTimeFactoryExtension::register($config);

		return $config->createContainer();
	}

}

$test_case = new SystemClockTest();
$test_case->run();
