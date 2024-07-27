<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\HttpResponses;
use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Carbon\Carbon;

class userController extends Controller
{
    use HttpResponses;
    //
    public function login(Request $request) {
        try {
        $credentials = array_map('trim', $request->only('username', 'password'));

        if(!Auth::attempt($credentials)){
            return $this->error('','Credentials do not match', 401);
        }

        $user = User::where('username', $request->username)->first();
        // Set the expiration time for the token (e.g., 1 hour from now)

         // Set the expiration time for the token (e.g., 1 hour from now)
         $expirationTime = Carbon::now()->addMinutes(5);
         $rt_expirationTime = Carbon::now()->addHours(168);
 
         $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], $expirationTime);
         $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $rt_expirationTime);
         
        return $this->success([
            'data'=>$user,
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error('Database error.');
        }
    }


    public function getUserDetails(){
        $user = Auth::user(); // Retrieve the authenticated user
        return response()->json(['user' => $user]);
    }

    public function refreshToken(Request $request){
        $expirationTime = Carbon::now()->addHours(1);
        $rt_expirationTime = Carbon::now()->addHours(168);
        $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], $expirationTime);
        $refreshToken = $request->user()->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $rt_expirationTime);
        return ['access_token' => $accessToken->plainTextToken, 'refresh_token' => $refreshToken->plainTextToken];
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return $this->success([
            'data' => 'Tokens revoked successfully'
        ]);
    }
}
