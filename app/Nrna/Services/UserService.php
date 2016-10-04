<?php

namespace App\Nrna\Services;


use App\Nrna\Models\Role;
use App\Nrna\Repositories\User\UserRepositoryInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;
    /**
     * @var Role
     */
    private $role;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $user
     * @param Role                    $role
     */
    public function __construct(UserRepositoryInterface $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @param $userData
     *
     * @return mixed
     */
    public function save($userData)
    {
        $userData['password'] = bcrypt($userData['password']);

        $user = $this->user->save($userData);
        $role = $this->role->where('name', $userData['role'])->first();
        if ($role) {
            $user->attachRole($role);
        }

        return $user;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    public function update($id, $userData)
    {
        if (isset($userData['password']) && !empty(trim($userData['password']))) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            unset($userData['password']);
        }
        $user = $this->user->find($id);

        $user->update($userData);
        if (\Entrust::hasRole('admin')) {
            $role = $this->role->where('name', $userData['role'])->first();
            $user->roles()->detach();
            $user->attachRole($role);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->user->destroy($id);
    }
}