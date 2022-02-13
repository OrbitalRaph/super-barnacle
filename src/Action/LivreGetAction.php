<?php

namespace App\Action;

use App\Domain\Livre\Service\LivreService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LivreGetAction {
	private $livreService;

	public function __construct( LivreService $livreService ) {
		$this->livreService = $livreService;
	}

	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		$args
	): ResponseInterface {

		$queryParams = $request->getQueryParams() ?? [];
		$page        = $queryParams['page'] ?? 1;
		$tri         = $queryParams['tri'] ?? 0;

		$livres = $this->livreService->fetchlivre( $tri );

		$pageTotal = ceil(( count( $livres ) / 20 ));
		$livres    = array_slice( $livres, 20 * ( $page - 1 ), 20 );
		$arrayPage = array(
			'livres'    => $livres,
			'page'      => $page,
			'pageTotal' => $pageTotal
		);

		$response->getBody()->write( (string) json_encode( array(
			'livres'    => $livres,
			'page'      => $page,
			'pageTotal' => $pageTotal
		) ) );

		return $response
			->withHeader( 'Content-Type', 'application/json' )
			->withStatus( 200 );
	}
}