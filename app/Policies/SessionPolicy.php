<?php

namespace App\Policies;

use App\User;
use App\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function index(User $user, Session $session)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }


    public function read_session(User $user, Session $session)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create sessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_session(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function update_session(User $user, Session $session)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function delete_session(User $user, Session $session)
    {
        return $user->role === 'admin';
    }
}
