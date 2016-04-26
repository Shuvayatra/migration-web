<?php

namespace App\Nrna\Repositories\User;

use App\Nrna\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $userData
     * @return static
     */
    public function save($userData)
    {
        return $this->user->create($userData);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->user->destroy($id);
    }
}