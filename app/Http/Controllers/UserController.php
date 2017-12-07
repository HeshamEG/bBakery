<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
/**
 * Created by PhpStorm.
 * User: a4p5
 * Date: 12/7/2017
 * Time: 2:26 PM
 */
class UserController extends Controller{
    public function signup(Request $request){
$email=$request['email'];
$password=bcrypt($request['$password']);
$phone=$request['phone'];
$name=$request['name'];
$image=$request['image'];//
        $user=new User;
        $user->email=$email;
        $user->password=$password;
        $user->phone=$phone;
        $user->name=$name;
        $user->image=$image;
        $user->save();
        response()->json(['email'=>$user->email,'phone'=>$user->phone,'name'=>$user->name,
            'image'=>$user->image=$image]);    }
    public function signin(){

    }
}