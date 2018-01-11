<?php

namespace App\Http\Controllers;
use App\Items;
use Illuminate\Http\Request;
use App\User;
use App\favorites;
use App\Cart;
use App\ItemImages;
class ItemsController extends Controller
{
    public function __construct()
    {
        $this->items=new Items();
        $this->favorites=new favorites();
        $this->cart=new Cart();
        $this->itemimages=new itemimages();
    }

    public function addItem(Request $request){


        return (new Items)->addItem($request);
    }

    public function getProducts($user_id,$lang)
    {
//        $item=(new Items())->item_id;
        $output =  Items::with([ 'favorites' => function ($query) use ($user_id) {

            if (is_numeric($user_id)) {
                $query->where($this->favorites->getTable() . '.user_id', '=', $user_id);

            } else {
                $query->where($this->favorites->getTable() . '.token', '=', $user_id);
            }
        }
            , 'Cart' => function ($query) use ($user_id) {

                if (is_numeric($user_id)) {
                    $query->where($this->cart->getTable() . '.user_id', '=', $user_id);
                } else {
                    $query->where($this->cart->getTable() . '.token', '=', $user_id);
                }
            },'itemimages'])->get();
        $items=[];
        foreach ($output as $item){

            if($lang=='ar'){
                $item->item_name= $item->item_name;
                $item->itemdetails_ar= $item->itemdetails_ar;
                $item->messure_unit_ar= $item->messure_unit_ar;
                array_push($items,$item);
            }else{
                $item->item_name= $item->item_nameen;
                $item->itemdetails_ar= $item->itemdetails_en;
                $item->messure_unit_ar= $item->messure_unit_en;

                array_push($items,$item);

            }


        }
        return Response()->json($items);
    }



    public function getCategoryProducts($lang,$user_id,$category_id)
    {
        $output =  Items::with([ 'favorites' => function ($query) use ($user_id) {

            if (is_numeric($user_id)) {
                $query->where($this->favorites->getTable() . '.user_id', '=', $user_id);

            } else {
                $query->where($this->favorites->getTable() . '.token', '=', $user_id);
            }
        }
            , 'Cart' => function ($query) use ($user_id) {

                if (is_numeric($user_id)) {
                    $query->where($this->cart->getTable() . '.user_id', '=', $user_id);
                } else {
                    $query->where($this->cart->getTable() . '.token', '=', $user_id);
                }
            },'itemimages'
        ])->where('category_id',$category_id)->get();

        $items=[];


        foreach ($output as $item){
            if($lang=='ar'){
                $item->item_name= $item->item_name;
                $item->itemdetails_ar= $item->itemdetails_ar;
                $item->messure_unit_ar= $item->messure_unit_ar;
                array_push($items,$item);
            }else{
                $item->item_name= $item->item_nameen;
                $item->itemdetails_ar= $item->itemdetails_en;
                $item->messure_unit_ar= $item->messure_unit_en;

                array_push($items,$item);

            }}


        return Response()->json($items);
    }
}
