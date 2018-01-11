<?php

namespace App;
use App\ItemImages;
use Illuminate\Database\Eloquent\Model;
use App\favorites;
//use App\Http\Middleware\ApiLang;
use Illuminate\Support\Facades\App;


class Items extends Model
{

    //
    protected $table='items';
    protected $primaryKey='item_id';
    //  protected $fillable=[ 'item_name', 'item_nameen', 'itemdetails_ar', 'itemdetails_en', 'price', 'category_id', 'quantity', 'messure_unit_ar', 'messure_unit_en', 'item_totalrate', 'item_ratedtimes', 'item_isfavorite', 'updated_at', 'created_at'];
//    public function comments()
//    {
//        return $this->hasMany('App\Comment');
//    }
//    public function getitemNameAttribute($value) {
//        if(session()->has('lang') )
//            return $value;
//        if(App::getLocale() == 'en')
//            $value = $this->item_nameen;
//        return $value;
//    }
//    public function getitemdetailsArAttribute($value) {
//        if(session()->has('lang') )
//            return $value;
//        if(App::getLocale() == 'en')
//            $value = $this->itemdetails_en;
//        return $value;
//    }
    public function favorites()
    {
        return $this->hasMany('App\favorites','item_id');
    }
    public function cart()
    {
        return $this->hasMany('App\Cart','item_id');
    }
    public function itemimages()
    {
        return $this->hasMany('App\itemimages','item_id');
    }
    public function addItem($request){
        $item=new Items;
//        $item->item_id= $request->input('item_id');
        $item->item_name= $request->input('itemname_ar');
        $item->item_nameen= $request->input('itemname_en');
        $item->itemdetails_ar= $request->input('itemdetails_ar');
        $item->itemdetails_en= $request->input('itemdetails_en');
        $item->price= $request->input('price');
        $item->category_id= $request->input('category_id');
        $item->quantity= $request->input('quantity');
        $item->messure_unit_ar= $request->input('messure_unit_ar');
        $item->messure_unit_en= $request->input('messure_unit_en');
//        return  response()->json(sizeof($item->item_image));
//        $item->item_image= $request->input('item_image');
        $item->save();
//        $item->item_image= $request->input('item_image');
        $itemId=$item->item_id;
        $noOfImages=sizeof($item->item_image);
        for($i=0;$i<=$noOfImages;$i++){
//            return  response()->json($request->input('item_image')[$i]);
            (new ItemImages)->storeItemImage($itemId,$request->input('item_image')[$i]);
        }

        return  response()->json($item);
    }
    public function getItems($request)
    {

    }

}
