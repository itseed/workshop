<?php
namespace App\Http\Controllers;

use App\Users;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return $this->responseRequestError($errors);
        } else {
            $user = new Users();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);

            if ($user->save()) {
                $token = $this->jwt($user);
                $user['api_token'] = $token;
                return $this->responseRequestSuccess($user);
            } else {
                return $this->responseRequestError('Cannot Register');
            }
        }
    }

    public function login(Request $request)
    {

        $user = Users::where('username', $request->username)
            ->first();

        if (!empty($user) && Hash::check($request->password, $user->password)) {
            $token = $this->jwt($user);
            $user["api_token"] = $token;

            return $this->responseRequestSuccess($user);
        } else {
            return $this->responseRequestError("Username or password is incorrect");
        }
    }

    protected function jwt($user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + env('JWT_EXPIRE_HOUR') * 60 * 60, // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

}