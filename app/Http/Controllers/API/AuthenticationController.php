<?php

namespace App\Http\Controllers\API;

use App\Exceptions\AuthenticationServiceException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthenticationService;
use App\Traits\ErrorResponseTrait;

class AuthenticationController extends Controller
{
    use ErrorResponseTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function login(Request $request, AuthenticationService $authenticationService)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        try {
            $token = $authenticationService->login($request->all());
        } catch (AuthenticationServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["token" => $token], 201);
    } //end method login

    public function register(Request $request, AuthenticationService $authenticationService)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        try {
            $authenticationService->registerUser($request->all());
        } catch (AuthenticationServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["message" => "Registration sucessful!"], 201);
    } //end method this is the register method

    public function logout(AuthenticationService $authenticationService)
    {

        try {
            $authenticationService->logout();
        } catch (AuthenticationServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["message" => "Registration sucessful!"], 201);
    } //end method logout


    public function me(AuthenticationService $authenticationService)
    {
        try {
            $user = $authenticationService->me();
        } catch (AuthenticationServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["user" => $user]);
    } //end method me
}//end class AuthenticationController
