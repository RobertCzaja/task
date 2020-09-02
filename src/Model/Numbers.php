<?php
declare(strict_types=1);

namespace App\Model;

use App\Exception\ClientNumbersException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="numbers")
 */
class Numbers
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

	/**
	 * @var int[]
	 *
     * @ORM\Column(type="simple_array", name="list")
	 */
	private array $numbers;

	/**
	 * @ORM\Column(type="boolean", name="is_asc")
	 */
	private bool $isAscending;

	public function __construct(int ...$numbers)
	{
		if (count($numbers) <= 1) {
			throw new ClientNumbersException('List must contains at least two integers');
		}

		$this->numbers = $numbers;
		$this->isAscending = $this->isAscending();
	}

	public function isAscending(): bool
	{
        if (count(array_unique($this->numbers)) === 1) {
            return false;
        }

		$numbersTemp = $this->numbers;

		sort($numbersTemp);

		return $numbersTemp === $this->numbers;
	}

    /**
     * @return array|mixed[]
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'numbers' => $this->numbers,
            'isAscending' => $this->isAscending
        ];
    }

}
