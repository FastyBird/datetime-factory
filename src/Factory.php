<?php declare(strict_types = 1);

/**
 * DateFactory.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:Factory!
 * @subpackage     common
 * @since          0.1.0
 *
 * @date           08.03.20
 */

namespace FastyBird\DateTimeFactory;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Nette;

class Factory
{

	use Nette\SmartObject;

	private DateTimeZone $timezone;

	public function __construct(string $timezone = 'Europe/Prague')
	{
		$this->timezone = new DateTimeZone($timezone);
	}

	public function getNow(): DateTimeInterface
	{
		$dateTime = new DateTimeImmutable();

		$dateTime = $dateTime->setTimezone($this->timezone);

		return $dateTime;
	}

}
