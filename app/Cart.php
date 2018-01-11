<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table='cart';
    protected $primaryKey='cart_id';

    public function items()
    {
        return $this->belongsTo('App\Items','item_id');
    }
    public function itemimages()
    {
        return $this->belongsTo('App\itemimages','item_id');
    }
}
