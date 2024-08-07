<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\institutionModel;
use App\Traits\HttpResponses;
use App\Enums\TokenAbility;
use Hash;
use Carbon\Carbon;

class schoolController extends Controller
{
    //
    use HttpResponses;

    public function storeSchool(request $request){
        try {
            $user = new User;
            $user->username = $request->username;
            $user->roleId = 3;
            $user->password = $request->password;
            $res = $user->save();

        if($res){
            $institution = new institutionModel;
            $institution->userId = $user->id;
            $institution->institutionName = $request->institutionName;
            $institution->momoNumber = $request->momoNo;
            $institution->otherNo = $request->otherNo;
            $institution->email = $request->email;
            $institution->address = $request->address;
            $res2 = $institution->save();

                 // Set the expiration time for the token (e.g., 1 hour from now)
         $expirationTime = Carbon::now()->addMinutes(5);
         $rt_expirationTime = Carbon::now()->addHours(168);
 
         $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], $expirationTime);
         $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $rt_expirationTime);

        if($res2){
            return $this->success([
                'data' => $user,
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
            ]);
            }
        }

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            
                if ($errorCode == 1062) { // MySQL duplicate key error code
                    return $this->error('error', 'Username is already taken.', 400);
                } else {
                    return $this->error('Database error.');
                }
            }
        }
        
    
}
