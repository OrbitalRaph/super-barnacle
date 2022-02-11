<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserServiceRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        $sql = "INSERT INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

	/**
	 * Fetch users.
	 */
	public function fetchUser()
	{
		$sql = "SELECT * FROM Users;";

		$statement = $this->connection->query($sql);
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Fetch one user.
	 */
	public function fetchOneUser(int $id)
	{
		$sql = "SELECT * FROM Users WHERE id = $id;";

		$statement = $this->connection->query($sql);
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Delete one user.
	 */
	public function deleteOneUser( $id ): bool {
		$sql = "DELETE FROM Users WHERE id = $id;";

		return $this->connection->prepare($sql)->execute();
	}

	/**
	 * Insert user row.
	 *
	 * @param array $user The user
	 *
	 * @return bool success or failure
	 */
	public function modifyUser( array $user ): bool {
		$row = [
			'id' => $user['id'],
			'username' => $user['username'],
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'email' => $user['email'],
		];

		$sql = "UPDATE users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email WHERE id=:id;";

		return $this->connection->prepare($sql)->execute($row);;
	}
}
