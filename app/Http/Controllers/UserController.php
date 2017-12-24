<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Image;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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

        $image=$request->input('image');
        $filename=Seller::all()->last()->Id.'.'.'png';

        $location=public_path('profileImages/'.$filename);
        $locationThump=public_path('profileImages_thump/'.$filename);
        Image::make($image)->resize(50,20)->save($locationThump);
        Image::make($image)->resize(500,350)->save($location);
        $user->image=$filename;
    return    response()->json(['email'=>$user->email,'phone'=>$user->phone,'name'=>$user->name,
            'image'=>$user->image=$image]);




    }


    public function login(Request $request){

        $this->validate(
            $request,[
            'Phone'=>'required',
            'Password'=>'required'
        ]);

        $user=User::where('phone',$request->get('phone'))->get();
        $chekPhone=Seller::where('phone',$request->get('phone'))->exists();

        if($chekPhone) {
            if ($user[0]->Password === $request->get('password')) {

                return response() ->json($user[0]);
            } else {

                return response() ->json('wrong password');
            }
        }else{
            return response() ->json('not a user');
        }
    }
    public function test(){
        return 1;
    }
}