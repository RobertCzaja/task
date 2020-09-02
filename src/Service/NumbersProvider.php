<?php
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Model\Numbers;

final class NumbersProvider
{
	private EntityRepository $numbersRepository;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->numbersRepository = $entityManager->getRepository(Numbers::class);
	}

	/**
	 * @return array|array[]
	 */
	public function serializeLastAdded(int $count = 10): array
	{
		return array_map(
			fn(Numbers $numbers) => $numbers->toArray(),
			$this->numbersRepository->findBy([], ['id' => 'desc'], $count)
		);
	}
}
