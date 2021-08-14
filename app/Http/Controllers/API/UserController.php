<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UserServiceException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthenticationService;
use App\Services\UserService;
use App\Traits\ErrorResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ErrorResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Check the registerUser function of the App\Services\AuthenticationService class
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(["user" => $user]);
    } //end method show

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserService $userService)
    {
        $request->validate([
            "_role" => "string", // to attach user to a role
            "password" => "string",
            "name" => "string",
            "title" => "string",
            "phone_number" => "string",
            "address" => "string",
            "address_2" => "string",
            "city" => "string",
            "state" => "string",
            "country" => "string",
            "zip_code" => "string",
            "about" => "string",
            "profile_photo" => "image",
            "landline" => "string",
            "facebook" => "string",
            "twitter" => "string",
            "linkedin" => "string",
            "google_plus" => "string",
            "instagram" => "string",
            "tumbler" => "string",
        ]);


        try {
            //createOrUpdate the user
            $user = $userService
                ->clearUser()
                ->user(auth()->user())
                ->updateOrCreateUser($request->all(), ["email"])
                ->save()
                ->getUser();
        } catch (UserServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["message" => "Registration sucessful!", "id" => $user->id]);
    } //end method update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return response()->json("You can't delete this account");
        }

        $user->delete();

        return response()->json(["message" => "User deleted"], 202);
    } //end method destroy
}//end class UserController
