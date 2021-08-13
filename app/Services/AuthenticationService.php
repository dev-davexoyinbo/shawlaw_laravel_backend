<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticationServiceException;
use App\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Throwable;

class AuthenticationService
{
    private User $user;

    public function getUser(): User
    {
        return $this->user;
    } //end method getUser

    public function registerUser($data): AuthenticationService
    {
        $user = new User();
        $user->first_name = $data["first_name"] ?? "";
        $user->last_name = $data["last_name"] ?? "";
        $user->email = $data["email"];
        $user->password = Hash::make($data["password"]);

        if (User::whereRaw(DB::raw("LOWER(email) = ?"), [strtolower($user->email)])->exists()) {
            throw new AuthenticationServiceException("Email already in use", 400);
        }

        $role = Role::where("name", "USER")->first();

        $user->save();

        // give every registered user a role of USER
        $user->roles()->attach($role->id);

        $this->user = $user;
        return $this;
    } //end method registerUser

    public function login($data): string
    {
        $email = $data["email"];
        $password = $data["password"];

        $token = auth()->attempt(["email" => $email, "password" => $password]);

        if (!$token) {
            throw new AuthenticationServiceException("Email/Password combination not correct");
        }

        return $token;
    } //end method login

    public function logout()
    {
        try {
            auth()->logout();
        } catch (Throwable $e) {
            throw new AuthenticationServiceException($e->getMessage(), 500);
        }
    } //end method logout

    public function me(): User
    {
        $rolePriviledgeService = App::make(RoleAndPriviledgeService::class);

        $user = auth()->user();

        [$user->permissions, $user->roles] = $rolePriviledgeService->user($user)->getPermissionAndRoleList();

        return $user;
    } //end method me
}//end class AuthenticationService