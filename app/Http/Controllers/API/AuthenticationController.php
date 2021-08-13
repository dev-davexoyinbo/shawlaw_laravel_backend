<?php

namespace App\Http\Controllers\API;

use App\Exceptions\AuthenticationServiceException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    public function register(Request $request, AuthenticationService $authenticationService)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        try {
            $authenticationService->registerUser($request->all());
        } catch (AuthenticationServiceException $e) {
            $message = $e->getMessage() ?? "An error occured";
            $code = $e->getCode() == 0 ? 400 : $e->getCode();

            return response()->json(["message" => $message], $code);
        }

        return response()->json(["message" => "Registration sucessful!"], 201);
    } //end method this is the register method
}//end class AuthenticationController
