<?php declare(strict_types = 1);

/**
 * DateTimeFactoryExtension.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:DateTimeFactory!
 * @subpackage     DI
 * @since          0.1.0
 *
 * @date           08.03.20
 */

namespace FastyBird\DateTimeFactory\DI;

use DateTimeZone;
use FastyBird\DateTimeFactory;
use FastyBird\DateTimeFactory\Exceptions;
use Nette;
use Nette\DI;
use Nette\Schema;
use stdClass;
use function assert;
use function in_array;

/**
 * Date&Time factory extension container
 *
 * @package        FastyBird:DateTimeFactory!
 * @subpackage     DI
 *
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 */
class DateTimeFactoryExtension extends DI\CompilerExtension
{

	public static function register(
		Nette\Configurator $config,
		string $extensionName = 'dateTimeFactory',
	): void
	{
		$config->onCompile[] = static function (
			Nette\Configurator $config,
			DI\Compiler $compiler,
		) use ($extensionName): void {
			$compiler->addExtension($extensionName, new DateTimeFactoryExtension());
		};
	}

	public function getConfigSchema(): Schema\Schema
	{
		return Schema\Expect::structure([
			'timezone' => Schema\Expect::string('UTC'),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$configuration = $this->getConfig();
		assert($configuration instanceof stdClass);

		if (
			!in_array($configuration->timezone, DateTimeZone::listIdentifiers(), true)
		) {
			throw new Exceptions\InvalidArgument('Timezone have to be valid PHP timezone string');
		}

		$builder->addDefinition($this->prefix('datetime.factory'), new DI\Definitions\ServiceDefinition())
			->setType(DateTimeFactory\Factory::class)
			->setArgument('timezone', $configuration->timezone);
	}

}
