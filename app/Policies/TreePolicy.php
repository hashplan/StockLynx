<?php

namespace App\Policies;

use App\User;
use App\Model\RosettaTrees;
use Illuminate\Auth\Access\HandlesAuthorization;

class TreePolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, RosettaTrees $item)
    {
        return true;//(!$user->isSuperAdmin() && !$user->isManager())?true:false;
    }

    /**
     * @param User $user
     * @param RosettaTrees $item
     *
     * @return bool
     */
    public function display(User $user, RosettaTrees $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param RosettaTrees $item
     *
     * @return bool
     */
    public function edit(User $user, RosettaTrees $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param RosettaTrees $item
     *
     * @return bool
     */
    public function delete(User $user, RosettaTrees $item)
    {
        return true;//$item->id > 2;
    }
}
