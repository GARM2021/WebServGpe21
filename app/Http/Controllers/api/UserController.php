<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    var $content = array();
    var $statusCode = 200;

    public function __construct()
    {
        $this->content = array();
    }

    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
        {
            $user = Auth::user();
            $this->content['token'] = $user->createToken('GpeApp')->accessToken;
            $this->statusCode = 200;
        } else {
            $this->content['error'] = "Unahutorised";
            $this->statusCode = 401;
        }

        return response()->json($this->content, $this->statusCode);
    }

    public function register()
    {
        $datos = [
            "name" => "Administrator",
            "email" => "alvaromares@gmail.com",
            "password" => bcrypt('mares')
        ];

        $user = new User();
        $user->name = "Alejandro";
        $user->email = "alejandro.alanis@sistemasag.net";
        $user->password = bcrypt('S_2h,98!-U');
        $user->save();
    }
}