<?php

namespace Authenticate\Repositories\User;

use Authenticate\Models\User;

class EloquentUserRepositry
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create new user
     *
     * @param object|array user valid inputs
     *
     * @return User|object
     */
    public function create($request)
    {
        return $this->user->create([
            'full_name' => $request['full-name'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
        ]);
    }


    /* Get user with username input
    *
    * @param string $username user validated username input .
    *
    * @return User
    */
    public function getUserWithUsername(string $username)
    {
        return $this->user->whereUsername($username)->first();
    }
}
