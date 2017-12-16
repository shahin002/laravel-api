<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 100;

    /*Login function*/
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json(array('meta' => array('status' => $this->failureStatus), 'response' => $response));
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();
            $response['token'] = $user->createToken('MyApp')->accessToken;
            $response['user'] = $user;
            $response['message'] = "Login Successfull";
            return response()->json(array('meta' => array('status' => $this->successStatus), 'response' => $response));
        } else {
            $response['message'] = "Credentials do not match";
            return response()->json(array('meta' => array('status' => $this->failureStatus), 'response' => $response));

        }
    }

    /*Register function*/
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'profile_picture' => 'required|image',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json(array('meta' => array('status' => $this->failureStatus), 'response' => $response));
        }

        $input = $request->all();
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . $file->getClientOriginalName();
            $path = 'content-dir/posts/images/' . $filename;
            $destinationPath = base_path($path);
            $img = Image::make($file);
            $img->save($destinationPath);
            $input['profile_picture'] = $path;
        }
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $response['token'] = $user->createToken('MyApp')->accessToken;
        $response['user'] = $user;
        return response()->json(array('meta' => array('status' => $this->successStatus), 'response' => $response));

    }


    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $success['message'] = "Logout succesfull";
            return response()->json(['response' => $success], $this->successStatus);
        }
    }

    public function userDetails()
    {
        $user = Auth::user()->with('userDetails')->first();
        if ($user) {
            $response['user'] = $user;
            $response['message'] = "User Information";
            return response()->json(array('meta' => array('status' => $this->successStatus), 'response' => $response));
        } else {
            $response['message'] = "No user found";
            return response()->json(array('meta' => array('status' => $this->failureStatus), 'response' => $response));

        }

    }

    public function userDetailsById($id)
    {
        $user = User::where('id', $id)->with('userDetails')->first();

        if ($user) {
            $response['user'] = $user;
            $response['message'] = "User Information";
            return response()->json(array('meta' => array('status' => $this->successStatus), 'response' => $response));
        } else {
            $response['message'] = "No user found";
            return response()->json(array('meta' => array('status' => $this->failureStatus), 'response' => $response));

        }
    }


}