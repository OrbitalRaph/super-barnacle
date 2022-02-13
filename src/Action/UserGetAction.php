<?php

namespace App\Action;

use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserGetAction {
	private $userService;

	public function __construct( UserService $userService ) {
		$this->userService = $userService;
	}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		$args
	): ResponseInterface {


		if ( isset( $args["id"] ) ) {
			$users = $this->userService->fetchOneUser( $args["id"] );
		} else {
			$queryParams = $request->getQueryParams() ?? [];
			$filtre      = $queryParams['filtre'] ?? '';
			$tri         = $queryParams['tri'] ?? '';
			$page        = $queryParams['page'] ?? 0;

			$users = $this->userService->fetchUser();

			if ( $tri != '' ) {
				usort( $users, function ( $a, $b ) use ( $tri ) {
					return $a[ $tri ] <=> $b[ $tri ];
				} );
			}
			if ( $page != 0 ) {
				$users = array_slice( $users, 10 * ( $page - 1 ), 10 );
			}

		}

		$response->getBody()->write( (string) json_encode( $users ) );

		return $response
			->withHeader( 'Content-Type', 'application/json' )
			->withStatus( 200 );
	}
}