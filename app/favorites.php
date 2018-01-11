<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Items;
use App\ItemImages;

class favorites extends Model
{
//    public function items()
//    {
//        return $this->belongsTo('App\Items', 'item_id');
//    }
    //
    protected $table='favorites';
protected $primaryKey='favorite_id';
    public function items()
    {
        return $this->belongsTo('App\Items','item_id');
    }
    public function itemimages()
    {
        return $this->belongsTo('App\itemimages','item_id');
    }
}
