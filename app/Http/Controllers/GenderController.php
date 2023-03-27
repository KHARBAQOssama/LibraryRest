<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Cache\Store;
use App\Http\Requests\StoreGenderRequest;

class GenderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['genders'=>Gender::all()]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenderRequest $request)
    {
        if(!JWTAuth::user()->hasPermission('addGender')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }
        
        $gender = Gender::create($request->only([
            'name',
        ]));

        return response()->json([
            'message' => 'gender added successfully',
            'gender' => $gender
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (!Gender::find($id)) {
            return response()->json([
                'error' => 'Gender not found.'
            ], 404);
        }

        return response()->json(Gender::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGenderRequest $request, int $id)
    {
        if(!JWTAuth::user()->hasPermission('updateGender')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }

        $gender = Gender::find($id);

        if (!$gender) {
            return response()->json([
                'error' => 'Gender not found.'
            ], 404);
        }

        $gender->update($request->only([
            'name',
        ]));

        return response()->json([
            'message' => 'gender updated successfully',
            'gender' => $gender
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if(!JWTAuth::user()->hasPermission('deleteGender')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }

        $gender = Gender::find($id);
        
        if (!$gender) {
            return response()->json([
                'error' => 'Gender not found.'
            ], 404);
        }
    
        $gender->delete();
    
        return response()->json([
            'message' => 'Gender deleted successfully.'
        ], 200);
    }
}
