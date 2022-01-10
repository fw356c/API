<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;


class AuthController extends Controller
{
    public function create(Request $request)
    {
        $array = ['error'=>''];

        $rules = [
            'email'=> 'required|email|unique:users,email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){

            $array['errors'] = $validator->messages();
            return $array;
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $newUser = new User();
        $newUser->email = $email;
        $newUser->password = password_hash($password, PASSWORD_DEFAULT);
        $newUser->token = '';
        $newUser->save();



        return $array;
    }

    public function login(Request $request){
        $array = ['error'=>''];

        $creds= $request->only('email' , 'password');

        $token = Auth::attempt($creds);

        if($token) {

            $array['token'] = $token;

        } else {
            $array['error'] = 'Email e/ou senha incorrestos!';
        }

        return $array;
    }

    public function logout(Request $request){
        $array = ['error'=>''];

        Auth::logout();

        return $array;
    }

    public function me(){
        $array = ['error'=>''];

        $user = Auth::user();
        $array['email'] = $user->email;

        return $array;
    }
}
