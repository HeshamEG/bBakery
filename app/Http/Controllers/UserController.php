<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Items;
use App\favorites;
use App\Cart;
use App\ItemImages;

use Image;
use Illuminate\Support\Facades\Validator;
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



    public function signup(Request $request,$lang){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
//            'token'=>'required',
//            'password'=>'required',


        ]);
            $dataP=User::where('phone',$request->get('phone'))->exists();
            if(!$dataP){
                $user=new User;
                $user->name= $request->input('name');
                $user->email= $request->input('email');
                $user->phone= $request->input('phone');
                $user->token= $request->input('token');
                $user->password=md5($request->input('password'));

                $user->type= $request->input('type');
                $image=$request->input('image');

                if($image !=null) {
                    $filename = time(). '.' . 'png';
                    $location = public_path('profileImages/' . $filename);
                    Image::make($image)->resize(500, 350)->save($location);
                    $user->image = $filename;
                }
                $user->save();

    return    response()->json(['user_id'=>$user->user_id,'email'=>$user->email,'phone'=>$user->phone,'name'=>$user->name,
            'image'=>$user->image]);
         }else if( $dataP){
                if ($lang == 'ar') {
                return ['error' => 'هذه العضويه مسجله لدينا  بالفعل'];
            } else {
                return ['error' => 'this account already registered'];
            }
            }

        return response('else', 200 );

      
    }


    public function login(Request $request,$lang){
        $this->validate(
            $request,[
            'phone'=>'required',
            'password'=>'required',
//            'token'=>'required'
        ]);

        $user=User::where('phone',$request->get('phone'))->get();
        $chekPhone=User::where('phone',$request->get('phone'))->exists();
      $password=md5($request->input('password'));
//      return response() ->json($password);
        if($chekPhone) {



            if ($user[0]['password'] == $password) {
                User::where('phone',$request->get('phone'))->update(['token' =>$request->input('token')]);

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
    public function test(){
        return 1;
    }




   public function editaccount(Request $request,$lang){
        $this->validate($request,[
           'user_id'=>'required',
           'name'=>'required',
           'email'=>'required',
           'phone'=>'required',
           'password'=>'required',
       ]);
       $checkPhone=User::where('phone',$request->get('phone'))->exists();
$reqId=$request->get('user_id');
if(!$checkPhone){
    $user=User::where('user_id',$reqId)->update(
        ['name' =>$request->input('name')
            ,'email'=> $request->input('email')
            ,'phone'=> $request->input('phone')
            ,'password'=>  md5($request->input('password'))
        ]);
    $image=$request->input('image');
    $userInfo=User::find($reqId);
    if($image !=null) {
        $realbath = '/var/www/html/bakery/bBakery/public';
        $image=$request->input('image');
        $filename=time().'.'.'png';
        $location=$realbath.'/profileImages/'.$filename;
        Image::make($image)->resize(500,350)->save($location);
        $userInfo->image=$filename;
    }
    $userInfo->save();
    return response()->json($user);
    }

else{
    $getcheckedPhone=User::where('phone',$request->get('phone'))->get();

    $checkPhoneId=$getcheckedPhone[0]->user_id;

    if($checkPhoneId ==$reqId){
        $user=User::where('user_id',$reqId)->update(
            ['name' =>$request->input('name')
                ,'email'=> $request->input('email')
                ,'phone'=> $request->input('phone')
                ,'password'=>  md5($request->input('password'))
            ]);
        $image=$request->input('image');
        $userInfo=User::find($reqId);

        if($image !=null) {
            $realbath = '/var/www/html/bakery/bBakery/public';
            $image=$request->input('image');
            $filename=time().'.'.'png';
            $location=$realbath.'/profileImages/'.$filename;
            Image::make($image)->resize(500,350)->save($location);
            $userInfo->image=$filename;
        }
        $userInfo->save();
        return response()->json($user);
    }else{
        if ($lang == 'ar') {
            return ['error' => 'رقم الهاتف مسجل بحساب شخص اخر'];
        } else {
            return ['error' => 'this phone number is allready taken'];
        }
        }
}
}
public function tweeterAuth(Request $request){
    $this->validate(
        $request,[
        'tweeterId'=>'required',
//        'name'=>'required',
//        'email'=>'required',
//        'type'=>'required'
//            'password'=>'required'
    ]);

    $user=User::where('tweeterId',$request->get('tweeterId'))->get();
    $chekTweeter=User::where('tweeterId',$request->get('tweeterId'))->exists();
//        $password=md5($request->input('password'));
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
        return [$newuser];
        return response()->json(['user_id'=>$user['user_id'],'email'=>$user['email'],'phone'=>$user['phone'],'name'=>$user[0]['name'],
            'image'=>$user['image']]);
    }
//    $model= new User;
//    $model->tweeterlogin($request);
//    return response()->json(['res'=>$model->tweeterlogin($request)]);
}
    public function facebookAuth(Request $request){
        $this->validate(
            $request,[
            'facebookId'=>'required',
//        'name'=>'required',
//        'email'=>'required',
//        'type'=>'required'
//            'password'=>'required'
        ]);

        $user=User::where('facebookId',$request->get('facebookId'))->get();
        $chekTweeter=User::where('facebookId',$request->get('facebookId'))->exists();
//        $password=md5($request->input('password'));
        if($chekTweeter) {

            return response() ->json(['user_id'=>$user[0]['user_id'],'email'=>$user[0]['email'],'phone'=>$user[0]['phone'],'name'=>$user[0]['name'],
                'image'=>$user[0]['image']]);
        }else{

            $newuser=new User;
            $newuser->name= $request->input('name');
            $newuser->email= $request->input('email');
            $newuser->type= $request->input('type');
            $newuser->facebookId= $request->input('facebookId');
            $newuser->save();
            return [$newuser];
            return response()->json(['user_id'=>$newuser ['user_id'],'email'=>$newuser['email'],
                'phone'=>$newuser['phone'],'name'=>$newuser['name'],
                'image'=>$newuser['image']]);
        }

    }

}