<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this
            ->belongsToMany(User::class, "user_role", "role_id", "user_id")
            ->using(UserRole::class);
    } //end method users

    public function permissions()
    {
        return $this
            ->belongsToMany(Permission::class, "role_permission", "role_id", "permission_id")
            ->using(RolePermission::class);
    } //end method permissions
}//end class Role
