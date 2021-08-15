<?php

namespace App\Http\Controllers\API;

use App\Exceptions\PropertyServiceException;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Services\PropertyService;
use App\Traits\ErrorResponseTrait;
use Illuminate\Http\Request;

class PropertyController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PropertyService $propertyService)
    {
        $request->validate([
            "title" => "required",
            "status" => "required",
            "type" => "required",
            "price" => "required|numeric",
            "area" => "required",
            "bedroom_count" => "integer",
            "bathroom_count" => "integer",
            "gallery" => "required",
            "address" => "required",
            "city" => "required",
            "state" => "required",
            "country" => "required",
            "zip_code" => "required",
            "description" => "required",
            "building_age" => "string",
            "garage_count" => "integer",
            "room_count" => "integer",
            "other_features" => "json",
            "contact_name" => "required",
            "contact_email" => "required|email",
            "contact_phone" => "required",
            "is_featured" => "boolean"
        ]);

        try {
            $property = $propertyService
                ->clearUser()
                ->user(auth()->user())
                ->clearProperty()
                ->updateOrCreateProperty($request->all())
                ->save()
                ->getProperty();
        } catch (PropertyServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["message" => "Property created successfully", "id" => $property->id], 201);
    } //end method store

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return response()->json(["property" => $property]);
    } //end method show

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
