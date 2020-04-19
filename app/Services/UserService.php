<?php

namespace App\Services;

use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    /**
     * @inheritDoc
     */
    public function find(string $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    public function index(): LengthAwarePaginator
    {
        return User::paginate();
    }

    /**
     * @inheritDoc
     */
    public function show(string $id): User
    {
        return $this->find($id);
    }

    /**
     * Update a model.
     *
     * @param string $id
     * @param array $data
     * @return User
     */
    public function update(string $id, array $data): User
    {
        $user = $this->find($id);
        $user->fill($data);
        $user->save();

        return $user;
    }
}
