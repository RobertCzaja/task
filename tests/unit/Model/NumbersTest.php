<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Model\Numbers;
use App\Exception\ClientNumbersException;

final class NumbersTest extends TestCase
{
	/**
	 * @param array|int[] $ascendingNumbers
	 * @dataProvider ascendingNumbersProvider
	 */
	public function test_method_isAscending_recognizes_ascending_numbers_collection(array $ascendingNumbers): void
	{
		$this->assertTrue((new Numbers(...$ascendingNumbers))->isAscending());
	}

	public static function ascendingNumbersProvider(): iterable
	{
		yield 'positive numbers set' => [[1,2,3]];
		yield 'not unique values' => [[1,2,2,6]];
		yield 'negative numbers' => [[-1,0,1]];
	}

	/**
	 * @param array|int[] $numbers
	 * @dataProvider unsortedNumbersProvider
	 */
	public function test_when_given_numbers_collection_is_not_in_ascending_order_method_isAscending_returns_false(array $numbers): void
	{
		$this->assertFalse((new Numbers(...$numbers))->isAscending());
	}

	public static function unsortedNumbersProvider(): iterable
	{
		yield [[1,2,4,3]];
		yield [[4,3,2,1]];
		yield [[4,2,2,1]];
	}

	public function test_when_given_numbers_contains_only_one_unique_number_method_isAscending_returns_false(): void
	{
		$this->assertFalse((new Numbers(1,1,1,1))->isAscending());
	}

	public function test_given_to_constructor_numbers_collection_must_contains_at_least_two_elements(): void
	{
		$this->expectException(ClientNumbersException::class);
		new Numbers(1);
	}

	public function test_method_toArray_returns_serialized_Numbers_model(): void
	{
		$serializedNumbersModel = (new Numbers(1,2,3,4))->toArray();

		$this->assertArrayHasKey('id', $serializedNumbersModel);
		$this->assertArrayHasKey('numbers', $serializedNumbersModel);
		$this->assertArrayHasKey('isAscending', $serializedNumbersModel);
	}

}
