<?php

namespace App\Policies;

use App\User;
use App\Model\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagesPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, Page $item)
    {
        return false;//($user->isSuperAdmin())?true:false;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Page $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, Page $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, Page $item)
    {
        return true;//$item->id > 2;
    }
}
