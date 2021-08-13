<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticationServiceException;
use Illuminate\Support\Facades\DB;

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

        $user->save();

        $this->user = $user;
        return $this;
    } //end method registerUser
}//end class AuthenticationService