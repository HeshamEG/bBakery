<?php

namespace App\Http\Controllers;

use App\favorites;
use App\Items;
use Illuminate\Http\Request;
use App\ItemImages;

class FavoritesController extends Controller
{
    //
    public function __construct()
    {
        $this->items=new Items();
        $this->favorites=new favorites();
        $this->itemimages=new itemimages();

    }
    public function addToFavorites(Request $request){

        $this->validate($request,[
            'user_id'=>'required',
            'item_id'=>'required'
        ]);
        $check =favorites::where('user_id',$request->input('user_id'))->where('item_id',$request->input('item_id'))->exists();
        if(!$check){
            $insertNew=new favorites();
            $insertNew->user_id=$request->input('user_id');
            $insertNew->item_id=$request->input('item_id');
            $insertNew->save();
            return response()->json(!$check);
        }else{
            return response()->json(!$check);

        }
    }
    public function getUserfavourite(Request $request,$lang){

        $user_id=$request->get('user_id');
        $output = favorites::with([ 'Items.itemimages' => function ($query) use ($user_id) {
//            if (is_numeric($user_id)) {
//                $query->where($this->favorites->getTable() . '.user_id', '=', $user_id);
//            } else {
//                $query->where($this->favorites->getTable() . '.token', '=', $user_id);
//            }
            }
            //,'itemimages'
        ])->get();
        $items=[];


        foreach ($output as $item){
            if($lang=='ar'&&$user_id==$item->user_id){
                $item->item_name= $item->item_name;
                $item->itemdetails_ar= $item->itemdetails_ar;
                $item->messure_unit_ar= $item->messure_unit_ar;
                array_push($items,$item);
            }else if($lang=='en'&&$user_id==$item->user_id){
                $item->item_name= $item->item_nameen;
                $item->itemdetails_ar= $item->itemdetails_en;
                $item->messure_unit_ar= $item->messure_unit_en;

                array_push($items,$item);

            }}
        return response()->json($items);

    }


    public function deleteFavorites(Request $request){

        $this->validate($request,[
            'user_id'=>'required',
            'item_id'=>'required'
        ]);
        $deletedItem =favorites::where('user_id',$request->input('user_id'))->where('item_id',$request->input('item_id'))->delete();

        return response()->json($deletedItem);


    }
}
