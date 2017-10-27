<?php

namespace App\Nrna\Repositories\User;


interface UserRepositoryInterface
{

    /**
     * @param $userData
     * @return mixed
     */
    public function save($userData);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email);
}