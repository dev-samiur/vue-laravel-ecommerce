<?php

namespace App\Http\Controllers\API;

use App\User; 
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function index()
    {
        $users= User::whereNotIn('usertype', [1])->get();

        return response()->json($users);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'usertype' => 'required|in:2,3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = $request->only(['name', 'email', 'password', 'usertype']);
        $data['password'] = bcrypt($data['password']);
        $data['usertype']= (int) $data['usertype'];

        try {

            $user = User::create($data);

        }catch (QueryException $e) {
            
            return response()->json(['error' => $e]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('interieurUser')->accessToken,
        ]);
    }

    public function login(Request $request)
    {
        $response = ['error' => 'Unauthorised'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            $response = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('interieurUser')->accessToken,
            ];
        }

        return response()->json($response);
    }

    public function logout()
    {
        $accessToken = Auth::user()->token();

        //to log out from all devices

        // DB::table('oauth_refresh_tokens')
        //     ->where('access_token_id', $accessToken->id)
        //     ->update([
        //         'revoked' => true
        //     ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    
    }

    public function destroy()
    {
        $id= request('id');

        $user= User::findOrFail($id);

        $user->delete();

        return response()->json('success');
    }
}
