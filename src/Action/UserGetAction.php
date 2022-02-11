<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserGetAction
{
	private $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		$args
	): ResponseInterface {

		// Récupération des paramètres dans un tableau
		// S'il n'y a pas de paramètre, retourne un tableau vide
		$queryParams = $request->getQueryParams() ?? [];
		// Récupération de la valeur du paramètre page
		$page = $queryParams['page'] ?? 1;

		if (isset($args["id"])) {
			$users = $this->userService->fetchOneUser($args["id"]);
		} else {
			$users = $this->userService->fetchUser();
		}

		$response->getBody()->write((string)json_encode($users));

		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus(200);
	}
}