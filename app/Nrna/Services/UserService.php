<?php

namespace App\Nrna\Services;


use App\Nrna\Models\Role;
use App\Nrna\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Logging\Log;

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
     * @var PostService
     */
    private $postService;
    /**
     * @var Log
     */
    protected $logger;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $user
     * @param Role                    $role
     * @param PostService             $postService
     * @param Log                     $logger
     */
    public function __construct(UserRepositoryInterface $user, Role $role, PostService $postService, Log $logger)
    {
        $this->user = $user;
        $this->role = $role;
        $this->postService = $postService;
        $this->logger = $logger;
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
        $this->logger->error("Deleting user with id " . $id);
        $admin_id = $this->user->findByEmail('admin@nrna.app')['id'];

        if($id == $admin_id){

            $this->logger->error("Cannot delete admin@nrna.app user.");
        }else {

            if ($this->postService->assignToAdmin($id, $admin_id))
                return $this->user->destroy($id);

            $this->logger->error("Could not delete user, post assignment to admin was not successful");
        }
    }
}