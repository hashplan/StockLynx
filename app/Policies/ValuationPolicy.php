<?php

namespace App\Policies;

use App\User;
use App\Model\ValuationTree;
use Illuminate\Auth\Access\HandlesAuthorization;

class ValuationPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, ValuationTree $item)
    {
        return (!$user->isSuperAdmin() && !$user->isManager())?true:false;
    }

    /**
     * @param User $user
     * @param ValuationTree $item
     *
     * @return bool
     */
    public function display(User $user, ValuationTree $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param ValuationTree $item
     *
     * @return bool
     */
    public function edit(User $user, ValuationTree $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param TreeCapitalization $item
     *
     * @return bool
     */
    public function delete(User $user, ValuationTree $item)
    {
        return true;//$item->id > 2;
    }
}
