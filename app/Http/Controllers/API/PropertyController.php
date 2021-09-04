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
        $paginationData = Property::simplePaginate();

        return response()->json(["properties" => $paginationData]);
    } //end method index

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

        return response()->json([
            "message" => "Property created successfully",
            "id" => $property->id,
            "slug" => $property->slug
        ], 201);
    } //end method store

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        try {
            $property = PropertyService::getPropertyWithSlug($slug);
        } catch (PropertyServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["property" => $property]);
    } //end method show

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $slug, PropertyService $propertyService)
    {
        $request->validate([
            "title" => "string",
            "status" => "string",
            "type" => "string",
            "price" => "numeric",
            "area" => "string",
            "bedroom_count" => "integer",
            "bathroom_count" => "integer",
            // "gallery" => "required", // the gallery is not required since it would be set when it is being created
            "address" => "string",
            "city" => "string",
            "state" => "string",
            "country" => "string",
            "zip_code" => "string",
            "description" => "string",
            "building_age" => "string",
            "garage_count" => "integer",
            "room_count" => "integer",
            "other_features" => "json",
            "contact_name" => "string",
            "contact_email" => "email",
            "contact_phone" => "string",
            "is_featured" => "boolean"
        ]);

        try {
            $property = PropertyService::getPropertyWithSlug($slug);

            $property = $propertyService
                ->user(auth()->user())
                ->property($property)
                ->updateOrCreateProperty($request->all())
                ->save()
                ->getProperty();
        } catch (PropertyServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json([
            "message" => "Property updated successfully",
            "id" => $property->id,
            "slug" => $property->slug
        ]);
    } //end method update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $slug)
    {
        try {
            PropertyService::getPropertyWithSlug($slug)->delete();
        } catch (PropertyServiceException $e) {
            return $this->errorResponse($e);
        }

        return response()->json(["message" => "Property deleted successfully"], 202);
    } //end method destroy
}//end class PropertyController
