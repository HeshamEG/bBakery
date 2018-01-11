<?php
namespace App\Http\Controllers;
use App\Items;
use Illuminate\Http\Request;
use App\User;
use App\favorites;
use App\Cart;
use App\ItemImages;use App\categories;
use Image;
use Illuminate\Support\Facades\Validator;
//use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class categoriesController extends Controller
{
//  public function addCategory(Request $request,$lang){
//      $this->validate($request,[
//          'categoryname_ar'=>'required',
//          'categoryname_en'=>'required',
//          'category_image'=>'required',
////          'category_status'=>'required',
////          'category_activation'=>'required',
////            'password'=>'required',
//
//
//      ]);
//
////      $dataA=categories::where('categoryname_ar',$request->get('categoryname_ar'))->exists();
////      $dataB=categories::where('categoryname_en',$request->get('categoryname_en'))->exists();
////      if(!$dataA && !$dataB){
//          $user=new categories;
//          $user->categoryname_ar= $request->input('categoryname_ar');
//          $user->categoryname_en= $request->input('categoryname_en');
////          $user->category_status= $request->input('category_status');
////          $user->category_activation= $request->input('category_activation');
//
//          $image=$request->input('category_image');
//
//          if($image !=null) {
//              $filename = time(). '.' . 'png';
//              $location = public_path('categoriesImages/' . $filename);
//              Image::make($image)->resize(500, 350)->save($location);
//              $user->category_image= $filename;
//          }
//          $user->save();
//
//          return    response()->json($user);
////      }else if( $dataA || $dataB){
////          if ($lang == 'ar') {
////              return ['error' => 'هذا الصنف موجود مسبقا'];
////          } else {
////              return ['error' => 'this category is already added'];
////          }
////      }
//
//      return response('else', 200 );
//
//
//  }
public function getAllCatecories($lang){
//      return ['categoryname_'.$lang];

     $categories=categories::All();
    $items=[];


    foreach ($categories as $item){

        if($lang=='ar'){
            $item->categoryname_ar= $item->categoryname_ar;

            array_push($items,$item);
        }else{
            $item->categoryname_ar= $item->categoryname_en;

            array_push($items,$item);

        }}
    return response() ->json($items);
}


//    public function getActiveCatecories(){
//        $categories=categories::where('category_status','on')->where('category_activation',1)->get();
//
//        return response() ->json($categories);
//    }
//public function makeCategoryActiveDeactivate(Request $request){
//    $this->validate($request,[
//     'category_id'=>'required',
//     'category_mode'=>'required'
//    ]);
//    categories::where('categories_id',$request->get('category_id'))->update(
//        ['category_activation' =>$request->get('category_mode')]);
//    $categoryAfterChangeMode=categories::where('categories_id',$request->get('category_id'))->get();
//      return response()->json($categoryAfterChangeMode);
//}
//public function deleteCategory(Request $request){
//    $this->validate($request,['category_id'=>'required']);
//
//
//
//}



//
//    public function categoryDelete(Request $request){
//        $this->validate($request,[
//            'category_id'=>'required']);
//        $realbath = '/var/www/html/bakery/bBakery/public';
//
//        $item=$request->input('category_id');
//        $itemInfo= categories::where('categories_id',$request->input('category_id'))->get();
//        categories::where('categoryname_ar',$itemInfo[0]->categoryname_ar)->delete();
//
//            File::delete($realbath.'/categoriesImages\\' . $itemInfo[0]->Image);
//        categories::where('categories_id',$request->input('category_id'))->delete();
//
//
//        return response()->json($item);
//
//    }

}
