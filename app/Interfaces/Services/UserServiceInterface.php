<?php
namespace App\Interfaces\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    /**
     * Find model by id.
     *
     * @param string $id
     * @return User
     */
    public function find(string $id): User;

    /**
     * Find model by e-mail.
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User;

    /**
     * Paginate models.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator;

    /**
     * Display model.
     *
     * @param string $id
     * @return User
     */
    public function show(string $id): User;

    /**
     * Update a model.
     *
     * @param string $id
     * @param array $data
     * @return User
     */
    public function update(string $id, array $data): User;
}
