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

    public function agents(){
        $agents = User::whereHas("roles", function($query) {
            $query->where("roles.name", "AGENT");
        })
        ->with("roles:name,id")
        ->withCount("properties")
        ->orderBy("name")
        ->simplePaginate();

        return response()->json(["message" => "Agents fetched", "agents" => $agents]);
    }//end method agents
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
            "_role" => "nullable", // to attach user to a role
            "password" => "nullable",
            "name" => "nullable",
            "title" => "nullable",
            "phone_number" => "nullable",
            "address" => "nullable",
            "address_2" => "nullable",
            "city" => "nullable",
            "state" => "nullable",
            "country" => "nullable",
            "zip_code" => "nullable",
            "about" => "nullable",
            "profile_photo" => "image|nullable",
            "landline" => "nullable",
            "facebook" => "nullable",
            "twitter" => "nullable",
            "linkedin" => "nullable",
            "google_plus" => "nullable",
            "instagram" => "nullable",
            "tumbler" => "nullable",
            "is_active" => "nullable",
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

        return response()->json(["message" => "Update sucessful!", "id" => $user->id]);
    } //end method update

    public function toggleActive($id, UserService $userService) {

        try {
            $user = User::find($id);
            //createOrUpdate the user
            $user = $userService
                ->clearUser()
                ->user($user)
                ->updateOrCreateUser(["is_active" => !!!$user->is_active])
                ->save()
                ->getUser();
        } catch (UserServiceException $e) {
            return $this->errorResponse($e);
        }


        return response()->json(["message" => "Update sucessful!", "user" => $user]);
    }//end method toggleActive

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
