<?php

namespace App\Http\Controllers;

use App\User;
use App\Userorderlocations;
use Illuminate\Http\Request;
class UserorderlocationsController extends Controller
{
    public function __construct()
    {
        $this->locations=new Userorderlocations();
        $this->users=new User();
    }
    public function addOrderLocation(Request $request){
        $this->validate($request,[
            'location_label'=>'required',
            'user_id'=>'required',
            'lat'=>'required',
            'lng'=>'required',
        ]);
        $location=new Userorderlocations();
        $location->location_label=$request->location_label;
        $location->user_id=$request->user_id;
        $location->lat=$request->lat;
        $location->lng=$request->lng;
        $location->save();
        return response()->json($location);
    }
    public function getMyLocations(Request $request){
        $this->validate($request,[
            'user_id'=>'required'
        ]);

        $myLocations=Userorderlocations::where('user_id',$request->user_id)->get();
        return response()->json($myLocations);
    }
    public function deleteLocation(Request $request){
        $this->validate($request,[
            'location_id'=>'required'
        ]);
        $deleteLocation=Userorderlocations::where('location_id',$request->location_id)->delete();
        return response()->json($deleteLocation);
    }

}
