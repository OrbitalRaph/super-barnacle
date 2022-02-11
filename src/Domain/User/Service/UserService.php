<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserServiceRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserService
{
    /**
     * @var UserServiceRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserServiceRepository $repository The repository
     */
    public function __construct(UserServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertUser($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

	/**
	 * Fetch users.
	 */
	public function fetchUser()
	{
		return $this->repository->fetchUser();
	}

	/**
	 * Fetch 1 user.
	 */
	public function fetchOneUser(int $id)
	{
		return $this->repository->fetchOneUser($id);
	}

	/**
	 * Delete 1 user.
	 */
	public function deleteOneUser( $id ) {
		return $this->repository->deleteOneUser($id);
	}

	/**
	 * Insert user row.
	 *
	 * @param array $user The user
	 *
	 * @return bool success or failure
	 */
	public function modifyUser( array $data ): bool {
		return $this->repository->modifyUser($data);
	}
}
