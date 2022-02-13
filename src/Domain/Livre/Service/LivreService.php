<?php


namespace App\Domain\Livre\Service;

use App\Domain\Livre\Repository\LivreServiceRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class LivreService {
	/**
	 * @var LivreServiceRepository
	 */
	private $repository;

	/**
	 * The constructor.
	 *
	 * @param LivreServiceRepository $repository The repository
	 */
	public function __construct( LivreServiceRepository $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Fetch livres.
	 */
	public function fetchLivre(bool $tri) {
		return $this->repository->fetchLivre($tri);
	}

	/**
	 * Fetch 1 livre.
	 */
	public function fetchDescriptionLivre( int $id ) {
		return $this->repository->fetchDescriptionLivre( $id );
	}
}
