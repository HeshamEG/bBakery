<?php

namespace App;
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class ItemImages extends Model
{
    //
    protected $table='itemimages';
    protected $primaryKey='itemimages_id';



    public function storeItemImage($itemId,$imageEncoded){
        $itemImage=new ItemImages;
        $itemImage->itemimages_id=$itemId;
        $image=$imageEncoded;

        $Id=time();

        $realbath = '/var/www/html/bakery/bBakery/public';
        $filename=$Id.'.'.'png';
        $location=$realbath.'/ItemImages/'.$filename;

        Image::make($image)->resize(500,350)->save($location);
        $itemImage->image_path=$filename;
        $itemImage->item_id=$itemId;
        $itemImage->save();

    }

}
