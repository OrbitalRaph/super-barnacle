<?php

namespace App\Action;

use App\Domain\Livre\Service\LivreService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function PHPUnit\Framework\isEmpty;

final class LivreDescriptionGetAction {
	private $livreService;

	public function __construct( LivreService $livreService ) {
		$this->livreService = $livreService;
	}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		$args
	): ResponseInterface {
		if ( isset( $args["id"] ) ) {

			$livres = $this->livreService->fetchDescriptionLivre( $args["id"] );

			if ( count( $livres ) ) {
				$response->getBody()->write( (string) json_encode( $livres ) );

				return $response
					->withHeader( 'Content-Type', 'application/json' )
					->withStatus( 200 );
			}
		}

		$response->getBody()->write( (string) json_encode( array(
			'errors' => array(
				'code'    => '404',
				'message' => 'Le id n\'existe pas'
			)
		) ) );

		return $response
			->withHeader( 'Content-Type', 'application/json' )
			->withStatus( 404 );

	}
}