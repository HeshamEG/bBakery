<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\favorites;
use App\Cart;
class User extends Model
{
protected $table='user';
    public $primaryKey='user_id';

    public function favorites()
    {
        return $this->hasMany('App\favorites','user_id');
    }

    public function cart()
    {
        return $this->hasMany('App\Cart','user_id');
    }

     public function tweeterlogin(Request $request){
        
        $user=User::where('tweeterId',$request->get('tweeterId'))->get();
        $chekTweeter=User::where('tweeterId',$request->get('tweeterId'))->exists();
//        $password=md5($request->input('password'));
//      return response() ->json($password);
        if($chekTweeter) {
            return response() ->json(['user_id'=>$user[0]['user_id'],'email'=>$user[0]['email'],'phone'=>$user[0]['phone'],'name'=>$user[0]['name'],
                'image'=>$user[0]['image']]);
        }else{
            $newuser=new User;
            $newuser->name= $request->input('name');
            $newuser->email= $request->input('email');
            $newuser->type= $request->input('type');
            $newuser->tweeterId= $request->input('tweeterId');
            $newuser->save();
            return response()->json(['user_id'=>$user[0]['user_id'],'email'=>$user[0]['email'],'phone'=>$user[0]['phone'],'name'=>$user[0]['name'],
                'image'=>$user[0]['image']]);
        }
    }
    public function facebooklogin(Request $request,$lang){
        $this->validate(
            $request,[
            'phone'=>'required',
            'password'=>'required'
        ]);

        $user=User::where('phone',$request->get('phone'))->get();
        $chekPhone=User::where('phone',$request->get('phone'))->exists();
        $password=md5($request->input('password'));
//      return response() ->json($password);
        if($chekPhone) {

            if ($user[0]['password'] == $password) {

                return response() ->json(['user_id'=>$user[0]['user_id'],'email'=>$user[0]['email'],'phone'=>$user[0]['phone'],'name'=>$user[0]['name'],
                    'image'=>$user[0]['image']]);
            } else {

                if ($lang == 'ar') {
                    return ['error' => 'هذه العضويه غير مسجلة'];
                } else {
                    return ['error' => 'this account is not registered'];
                }            }
        }else{
            if ($lang == 'ar') {
                return ['error' => 'هذه العضويه غير مسجلة'];
            } else {
                return ['error' => 'this account is not registered'];
            }        }
    }
}

