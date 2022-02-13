<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

	// User
    $app->post('/users', \App\Action\UserCreateAction::class);
	$app->put('/users', \App\Action\UserPutAction::class);
	$app->get('/users[/{id:[0-9]+}]', \App\Action\UserGetAction::class);
	$app->delete('/users/{id:[0-9]+}', \App\Action\UserDeleteAction::class);

	// Livre
	$app->get('/livres', \App\Action\LivreGetAction::class);
	$app->get('/livres/{id}/description', \App\Action\LivreDescriptionGetAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

};

