<?php

namespace App\Policies;

use App\User;
use App\Model\Stocks;
use Illuminate\Auth\Access\HandlesAuthorization;

class StocksPolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, Stocks $item)
    {
        return ($user->isSuperAdmin())?true:false;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Stocks $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function edit(User $user, Stocks $item)
    {
        return true;//$item->id > 2;
    }

    /**
     * @param User $user
     * @param User $item
     *
     * @return bool
     */
    public function delete(User $user, Stocks $item)
    {
        return true;//$item->id > 2;
    }
}
