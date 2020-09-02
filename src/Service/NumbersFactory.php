<?php
declare(strict_types=1);

namespace App\Service;

use App\Exception\ClientNumbersException;
use App\Model\Numbers;

final class NumbersFactory
{
	/**
	 * @param unknown
	 * @throws ClientNumbersException on invalid numbers list
	 */
	public function getInstance($clientStructure): Numbers
	{
		if (null === $clientStructure) {
			throw new ClientNumbersException('Client payload cannot be null');
		}

		if (!is_array($clientStructure) || !array_key_exists('numbers', $clientStructure)) {
			throw new ClientNumbersException('Missing key numbers');
		}

		if (!is_array($clientStructure['numbers']) || !$this->hasOnlyIntegers($clientStructure['numbers'])) {
			throw new ClientNumbersException('Value of numbers key must contains array with integers only');
		}

		return new Numbers(
			...$clientStructure['numbers']
		);
	}

	private function hasOnlyIntegers(array $numbers): bool
	{
		return count(array_filter($numbers, 'is_int')) === count($numbers);
	}

}
