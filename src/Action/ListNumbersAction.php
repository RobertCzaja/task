<?php
declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\NumbersProvider;

final class ListNumbersAction
{
	private NumbersProvider $numbersProvider;

	public function __construct(NumbersProvider $numbersProvider)
	{
		$this->numbersProvider = $numbersProvider;
	}

	public function __invoke(Request $request, Response $response): Response
	{
		$response->getBody()->write(
			json_encode(
				$this->numbersProvider->serializeLastAdded()
			)
		);
		return $response->withHeader('Content-Type', 'application/json');
	}

}
