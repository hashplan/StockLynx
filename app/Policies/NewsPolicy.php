<?php

namespace App\Policies;

use App\User;
use App\Model\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, News $item)
    {
        return ($user->isSuperAdmin() || $user->isManager())?true:false;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, News $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, News $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, News $item)
    {
        return true;//$item->id > 2;
    }
}
