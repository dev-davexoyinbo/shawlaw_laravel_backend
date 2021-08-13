<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\RoleAndPriviledgeServiceException;
use App\Models\Permission;

class RoleAndPriviledgeService
{
    private User $user;

    public function user(User $user): RoleAndPriviledgeService
    {

        $this->user = $user;

        return $this;
    } //end method user

    //Returns [permissions, roles]
    public function getPermissionAndRoleList()
    {
        $user = $this->user;

        if (!$user) {
            throw new RoleAndPriviledgeServiceException("The user is not defined");
        }
        $permissions = $user->directPermissions()->get();

        $roles = $user->roles()->with("permissions")->get();

        $roles->each(function ($role) use (&$permissions) {
            $permissions = $permissions->merge($role->permissions);
        });

        $rv = [
            array_unique($permissions->pluck("name")->all()),
            array_unique($roles->pluck("name")->all())
        ];

        return $rv;
    } //end method getPermissions
}//end class RoleAndPriviledgeService