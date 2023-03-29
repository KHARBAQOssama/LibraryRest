<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['user'=>User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request)
    {
        
        if($user = JWTAuth::user()) {
            return response()->json(['error'=>'Unauthorized']);
        }
         $credentials = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
         ];

         $user = User::create($credentials);

         if(!$user){
            return response()->json(['error'=>'something wrong happened']);
         }

         return response()->json(['success'=>'your account has been created successfully'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateSelf(UpdateUserRequest $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email']);
        $user = JWTAuth::user();
        $user->update(
            $data
        );
        return response()->json([
            'message' => 'your profile has been updated successfully',
            'user' => $user
        ]);
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = JWTAuth::user();

        if(!password_verify($request->input('old_password'), $user->password)){
            return response()->json(['message' => 'Invalid old password'], 422);
        }

        $user->update([
                'password' => Hash::make($request->input('new_password'))
                ]);
        
        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
