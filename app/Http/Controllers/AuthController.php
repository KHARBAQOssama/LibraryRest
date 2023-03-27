<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','forgetPassword','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['user'=> JWTAuth::user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function forgetPassword(){
        request()->validate(['email' => 'required|email|exists:users']);
        $token = Str::random(64);

        $email = request('email');

        DB::table('password_reset_tokens')->insert([
            'email' => $email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);
        //1 : view - 2 : wlh ma39alt
        Mail::send([], [], function($message) use($email,$token){
            $message->to($email);
            $message->subject('Reset Password');
            $message->text(
                "please click on the link below to reset your password. \n
                http://localhost:8000/api/password/reset?email=".$email."&token=".$token
                            );
        });

        return response()->json(['message'=> 'check your email']);
    }

    
    public function reset(){
        request()->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
                            ->where([
                              'email' => request('email'), 
                              'token' => request('token')
                            ])
                            ->first();

        if(!$updatePassword){
            return response()->json(['error'=>'Invalid token!']);
        }

        $user = User::where('email', request('email'))
                    ->update(['password' => Hash::make(request('password'))]);

        DB::table('password_reset_tokens')->where(['email'=> request('email')])->delete();

        return response()->json(['message'=>'Your password has been changed!']);
    }
}