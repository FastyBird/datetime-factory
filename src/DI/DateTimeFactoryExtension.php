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

use Cassandra\Date;
use DateTimeZone;
use FastyBird\DateTimeFactory;
use FastyBird\DateTimeFactory\Exceptions;
use Nette;
use Nette\DI;
use Nette\Schema;
use stdClass;

/**
 * Microservice node helpers extension container
 *
 * @package        FastyBird:DateTimeFactory!
 * @subpackage     DI
 *
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 */
class DateTimeFactoryExtension extends DI\CompilerExtension
{

	/**
	 * {@inheritdoc}
	 */
	public function getConfigSchema(): Schema\Schema
	{
		return Schema\Expect::structure([
			'timezone'   => Schema\Expect::string('UTC'),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		/** @var stdClass $configuration */
		$configuration = $this->getConfig();

		if (
			!in_array($configuration->timezone, DateTimeZone::listIdentifiers(), true)
		) {
			throw new Exceptions\InvalidArgumentException('Timezone have to be valid PHP timezone string');
		}

		$builder->addDefinition(null)
			->setType(DateTimeFactory\DateTimeFactory::class)
			->setArgument('timezone', $configuration->timezone);
	}

	/**
	 * @param Nette\Configurator $config
	 * @param string $extensionName
	 *
	 * @return void
	 */
	public static function register(
		Nette\Configurator $config,
		string $extensionName = 'dateTimeFactory'
	): void {
		$config->onCompile[] = function (
			Nette\Configurator $config,
			DI\Compiler $compiler
		) use ($extensionName): void {
			$compiler->addExtension($extensionName, new DateTimeFactoryExtension());
		};
	}

}
