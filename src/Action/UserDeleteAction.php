<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserDeleteAction {
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
		$success = 0;
		if (isset($args["id"])) {
			$success = $this->userService->deleteOneUser($args["id"]);
		}

		// Transform the result into the JSON representation
		$result = [
			'success' => $success
		];

		// Build the HTTP response
		$response->getBody()->write((string)json_encode($result));

		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus(200);
	}
}