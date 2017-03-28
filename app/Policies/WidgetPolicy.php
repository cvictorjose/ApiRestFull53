<?php

namespace App\Policies;

use App\User;
use App\Widget;
use Illuminate\Auth\Access\HandlesAuthorization;

class WidgetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the widget.
     *
     * @param  \App\User  $user
     * @param  \App\Widget  $widget
     * @return mixed
     */
    public function index(User $user, Widget $widget)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_widget(User $user, Widget $widget)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create widgets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_widget(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the widget.
     *
     * @param  \App\User  $user
     * @param  \App\Widget  $widget
     * @return mixed
     */
    public function update_widget(User $user, Widget $widget)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the widget.
     *
     * @param  \App\User  $user
     * @param  \App\Widget  $widget
     * @return mixed
     */
    public function delete_widget(User $user, Widget $widget)
    {
        return $user->role === 'admin';
    }
}
