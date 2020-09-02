<?php
declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\NumbersProvider;
use Slim\Views\Twig;

final class IndexAction
{
	private NumbersProvider $numbersProvider;
	private Twig $twig;

	public function __construct(NumbersProvider $numbersProvider, Twig $twig)
	{
		$this->numbersProvider = $numbersProvider;
		$this->twig = $twig;
	}

	public function __invoke(Request $request, Response $response): Response
	{
		return $this->twig->render($response, 'index.html.twig', [
			'numbersCollection' => $this->numbersProvider->serializeLastAdded()
		]);
	}
}
