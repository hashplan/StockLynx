<?php

namespace App\Policies;

use App\User;
use App\Model\RosettaTree;
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
    public function before(User $user, $ability, RosettaTree $item)
    {
        return (!$user->isSuperAdmin() && !$user->isManager())?true:false;
    }

    /**
     * @param User $user
     * @param RosettaTree $item
     *
     * @return bool
     */
    public function display(User $user, RosettaTree $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param RosettaTree $item
     *
     * @return bool
     */
    public function edit(User $user, RosettaTree $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param RosettaTree $item
     *
     * @return bool
     */
    public function delete(User $user, RosettaTree $item)
    {
        return true;//$item->id > 2;
    }
}
