<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Items;
use Illuminate\Http\Request;
use App\User;
use App\favorites;
use App\ItemImages;
class CartController extends Controller
{
    public function __construct()
    {
        $this->items=new Items();
        $this->favorites=new favorites();
        $this->cart=new Cart();
        $this->itemimages=new itemimages();
    }

    public function addToCart(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'item_id'=>'required'
        ]);
        $check =Cart::where('user_id',$request->input('user_id'))->where('item_id',$request->input('item_id'))->exists();
        if(!$check){
            $insertNew= $this->cart;
            $insertNew->user_id=$request->input('user_id');
            $insertNew->item_id=$request->input('item_id');
            $insertNew->category_id=$request->input('category_id');

if($insertNew->category_id==1) {
    $insertNew->tart_size_id = $request->input('tart_size_id');
    $insertNew->tart_additonals_id = $request->input('tart_additonals_id');
    $insertNew->tart_color = $request->input('tart_color');

    $image=$request->input('tart_image');

    if($image !=null) {
        $realbath = '/var/www/html/bakery/bBakery/public';
        $filename=time().'.'.'png';
        $location=$realbath.'/tartImages/'.$filename;
        Image::make($image)->resize(500, 350)->save($location);
        $insertNew->tart_image= $filename;
    }
}
            $insertNew->save();
            return response()->json($insertNew);
        }else{
            $exsisteditem=Cart::where('user_id',$request->input('user_id'))
                ->where('item_id',$request->input('item_id'))->update(
                [
                    'quantity' =>$request->input('quantity'),
                    'tart_size_id' =>$request->input('tart_size_id'),
                    'tart_additonals_id' =>$request->input('tart_additonals_id'),
                    'tart_color' =>$request->input('tart_color'),

                ]);
            return response()->json($exsisteditem);

        }
    }


    public function getMyCart(Request $request,$lang){

        $user_id=$request->get('user_id');
        $output = Cart::with([ 'Items' => function ($query) use ($user_id) {
//            if (is_numeric($user_id)) {
//                $query->where($this->cart->getTable() . '.user_id', '=', $user_id);
//            } else {
//                $query->where($this->cart->getTable() . '.token', '=', $user_id);
//            }
        }
            ,'itemimages'
        ])->get();
        $items=[];


        foreach ($output as $item){
            if($lang=='ar'&&$user_id==$item->user_id){
                $item->items->item_name= $item->items->item_name;
                $item->items->itemdetails_ar= $item->items->itemdetails_ar;
                $item->items->messure_unit_ar= $item->items->messure_unit_ar;
                array_push($items,$item);
            }else if($lang=='en'&&$user_id==$item->user_id){
                $item->items->item_name= $item->items->item_nameen;
                $item->items->itemdetails_ar= $item->items->itemdetails_en;
                $item->items->messure_unit_ar= $item->items->messure_unit_en;

                array_push($items,$item);

            }
        }
        return response()->json($items);

    }

public function deleteItemFromCart(Request $request){
    $check =Cart::where('user_id',$request->input('user_id'))->where('item_id',$request->input('item_id'))->exists();
    if($check) {
        $deleteItem = Cart::where('user_id', $request->input('user_id'))->where('item_id', $request->input('item_id'))->delete();
    return response()->json($check);
    }else{
        return response()->json($check);

    }
}

}
