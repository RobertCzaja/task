<?php

use Slim\App;
use App\Action\{
	ListNumbersAction,
	AddNumbersAction,
	IndexAction
};

return function (App $app): void {
	$app->post('/add-numbers', [AddNumbersAction::class, '__invoke']);
	$app->get('/last-added', [ListNumbersAction::class, '__invoke']);
	$app->get('/', [IndexAction::class, '__invoke']);
};
