<?php


namespace App\Domain\Livre\Repository;

use PDO;

/**
 * Repository.
 */
class LivreServiceRepository {
	/**
	 * @var PDO The database connection
	 */
	private $connection;

	/**
	 * Constructor.
	 *
	 * @param PDO $connection The database connection
	 */
	public function __construct( PDO $connection ) {
		$this->connection = $connection;
	}

	/**
	 * Fetch livres.
	 */
	public function fetchLivre(bool $tri) {
		if ( $tri )
			$sql = "SELECT * FROM books ORDER BY title DESC;";
		else
			$sql = "SELECT * FROM books ORDER BY title ASC;";

		$statement = $this->connection->query( $sql );

		return $statement->fetchAll( \PDO::FETCH_ASSOC );
	}

	/**
	 * Fetch description of one livre.
	 */
	public function fetchDescriptionLivre( int $id ) {
		$sql = "SELECT id, title, description FROM books WHERE id = $id;";

		$statement = $this->connection->query( $sql );

		return $statement->fetchAll( \PDO::FETCH_ASSOC );
	}
}
