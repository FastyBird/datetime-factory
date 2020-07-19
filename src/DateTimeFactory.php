<?php declare(strict_types = 1);

/**
 * DateFactory.php
 *
 * @license        More in license.md
 * @copyright      https://www.fastybird.com
 * @author         Adam Kadlec <adam.kadlec@fastybird.com>
 * @package        FastyBird:NodeDateTime!
 * @subpackage     common
 * @since          0.1.0
 *
 * @date           08.03.20
 */

namespace FastyBird\NodeDateTime;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Nette;

class DateFactory
{

	use Nette\SmartObject;

	private $timezone;

	public function __construct(
		string $timezone = 'Europe/Prague'
	) {
		$this->timezone = new DateTimeZone($timezone);
	}

	/**
	 * @return DateTimeInterface
	 */
	public function getNow(): DateTimeInterface
	{
		$dateTime = new DateTimeImmutable();

		$dateTime->setTimezone($this->timezone);

		return $dateTime;
	}

}
