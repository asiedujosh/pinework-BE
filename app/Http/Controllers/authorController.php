<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\authorModel;
use App\Traits\HttpResponses;
use App\Enums\TokenAbility;
use Hash;
use Carbon\Carbon;


class authorController extends Controller
{
    //
    use HttpResponses;

    
    public function storeAuthor(Request $request){
        try {
        $user = new User;
        $user->username = $request->username;
        $user->roleId = 4;
        $user->password = $request->password;
        $res = $user->save();

        if($res){
            $author = new authorModel;
            $author->userId = $user->id;
            $author->fullName = $request->fullName;
            $author->momoNumber = $request->phoneNo;
            $author->otherNo = $request->otherNo;
            $author->email = $request->email;
            $author->address = $request->address;
            $res2 = $author->save();

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


     public function getAuthorInfo (Request $request, $id){
       $authorInfo = authorModel::where('userId', $id)->first();
       return $this->success([
        'data' => $authorInfo
        ]);
    }



}
