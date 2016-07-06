<?php

namespace App\Policies;

use App\User;
use App\Model\TreeCapitalization;
use Illuminate\Auth\Access\HandlesAuthorization;

class CapitalizationPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, TreeCapitalization $item)
    {
        return true;//(!$user->isSuperAdmin() && !$user->isManager())?true:false;
    }

    /**
     * @param User $user
     * @param TreeCapitalization $item
     *
     * @return bool
     */
    public function display(User $user, TreeCapitalization $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param TreeCapitalization $item
     *
     * @return bool
     */
    public function edit(User $user, TreeCapitalization $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param TreeCapitalization $item
     *
     * @return bool
     */
    public function delete(User $user, TreeCapitalization $item)
    {
        return true;//$item->id > 2;
    }
}
