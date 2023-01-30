<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ],200);
    }
//    public function reister(Request $request)
//    {
//        $data = $request->validate([
//            'name' => 'required|string',
//            'email' => 'required|email|string|unique:users,email',
//            'password' => [
//                'required',
//                'confirmed',
////                Password::min(8)->mixedCase()->numbers()->symbols()
//            ]
//        ]);
//
//        /** @var \App\Models\User $user */
//        $user = User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password'])
//        ]);
//        $token = $user->createToken('main')->plainTextToken;
//
//        return response([
//            'user' => $user,
//            'token' => $token
//        ]);
//    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
            //'remember' => 'boolean'
        ]);

        if ($token = $this->guard()->attempt($credentials)) {
            $user = Auth::user();
            return response([
                'user' => $user,
                'token' => $token,
                'status' => 'success'
            ],200);
        }
        return response([
            'error' => 'login_error'
        ],401);
    }

//    public function lgin(Request $request)
//    {
//        $credentials = $request->validate([
//            'email' => 'required|email|string|exists:users,email',
//            'password' => [
//                'required',
//            ],
//            'remember' => 'boolean'
//        ]);
//        $remember = $credentials['remember'] ?? false;
//        unset($credentials['remember']);
//
//        if (!Auth::attempt($credentials, $remember)) {
//            return response([
//                'error' => 'The Provided credentials are not correct'
//            ], 422);
//        }
//        $user = Auth::user();
//        $token = $user->createToken('main')->plainTextToken;
//
//        return response([
//            'user' => $user,
//            'token' => $token
//        ]);
//    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
//    public function logot() //my
//    {
//        /** @var User $user */
//        $user = Auth::user();
//        // Revoke the token that was used to authenticate the current request...
//        $user->currentAccessToken()->delete();
//
//        return response([
//            'success' => true
//        ]);
//    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
