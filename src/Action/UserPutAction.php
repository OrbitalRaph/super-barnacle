<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserPutAction
{
	private $userCreator;

	public function __construct(UserService $userCreator)
	{
		$this->userCreator = $userCreator;
	}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response
	): ResponseInterface {
		// Collect input from the HTTP request
		$data = (array)$request->getParsedBody();

		// Invoke the Domain with inputs and retain the result
		$success = $this->userCreator->modifyUser($data);

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