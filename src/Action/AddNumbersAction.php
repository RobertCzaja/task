<?php
declare(strict_types=1);

namespace App\Action;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\NumbersFactory;
use App\Exception\ClientNumbersException;

final class AddNumbersAction
{
	private NumbersFactory $numbersFactory;
	private EntityManagerInterface $entityManager;

	public function __construct(
		NumbersFactory $numbersFactory,
		EntityManagerInterface $entityManager
	) {
		$this->numbersFactory = $numbersFactory;
		$this->entityManager = $entityManager;
	}

	public function __invoke(Request $request, Response $response): Response
	{
		try {
			$numbers = $this->numbersFactory->getInstance($request->getParsedBody());

			$this->entityManager->persist($numbers);
			$this->entityManager->flush();

			$response->getBody()->write(json_encode([
				'isAscending' => $numbers->isAscending()
			]));
		} catch (ClientNumbersException $e) {
			$response->getBody()->write(json_encode([
				'errorMessage' => $e->getMessage()
			]));
		}

        return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus(isset($e) ? 400 : 200);
	}
}
