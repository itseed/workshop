<?php
namespace App\Http\Controllers;

// use App\Users;
// use Firebase\JWT\JWT;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;
use  App\User;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    // public function register(Request $request)
    // {
    //     // validator
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|unique:users',
    //         'username' => 'required|unique:users',
    //         'password' => 'required',
    //         'name' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors();

    //         return $this->responseRequestError($errors);
    //     } else {
    //         $user = new Users();
    //         $user->email = $request->email;
    //         $user->name = $request->name;
    //         $user->username = $request->username;
    //         $user->password = Hash::make($request->password);

    //         if ($user->save()) {
    //             $token = $this->jwt($user);
    //             $user['token'] = $token;
    //             return $this->responseRequestSuccess($user);
    //         } else {
    //             return $this->responseRequestError('Cannot Register');
    //         }
    //     }
    // }

    // public function login(Request $request)
    // {

    //     $user = Users::where('username', $request->username)
    //         ->first();

    //     if (!empty($user) && Hash::check($request->password, $user->password)) {
    //         $token = $this->jwt($user);
    //         $user["token"] = $token;

    //         return $this->responseRequestSuccess($user);
    //     } else {
    //         return $this->responseRequestError("Username or password is incorrect");
    //     }
    // }

    // public function me(Request $request){
    //     $token = $request->header('Authorization');
    //     $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
    //     $user = Users::find($credentials->sub);
    //     if (!$token) {
    //         // Unauthorized response if token not there
    //         return response()->json([
    //             'error' => 'Token not provided.',
    //         ], 401);
    //     }
    //     try {
    //         $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
    //     } catch (ExpiredException $e) {
    //         return response()->json([
    //             'error' => 'Provided token is expired.',
    //         ], 400);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'An error while decoding token.',
    //         ], 400);
    //     }
    //     $user = Users::find($credentials->sub);
    //     // // echo $user;
    //     // // Now let's put the user in the request class so that you can grab it from there
    //     // $request->auth = $user;
    //     return response()->json([
    //         'data' => $user,
    //     ], 200);
    // }

    // protected function jwt($user)
    // {
    //     $payload = [
    //         'iss' => "lumen-jwt", // Issuer of the token
    //         'sub' => $user->id, // Subject of the token
    //         'token_type' => 'bearer',
    //         'iat' => time(), // Time when JWT was issued.
    //         'exp' => time() + env('JWT_EXPIRE_HOUR') * 60 * 60, // Expiration time
    //     ];

    //     return JWT::encode($payload, env('JWT_SECRET'));
    // }

    // protected function responseRequestSuccess($ret)
    // {
    //     return response()->json(['status' => 'success', 'data' => $ret], 200)
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    // }

    // protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    // {
    //     return response()->json(['status' => 'error', 'error' => $message], $statusCode)
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    // }

}