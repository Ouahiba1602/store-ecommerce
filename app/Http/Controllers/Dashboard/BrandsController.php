<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helpers\uploadImage;

class BrandsController extends Controller
{
    public function index(){
         $brands = Brand::orderBy('id', 'DESC') -> paginate(PAGINATION_COUNT);
       return view('admin.brands.index', compact('brands') );
    }

    public function create(){
        return view('admin.brands.create');
    }
    public function store(BrandRequest $request){


            //validation

            //update db

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $fileName = "";
            if ($request->has('photo')){
                $fileName = uploadImage('brands', $request->photo);
            }
            DB::beginTransaction();

          $brands = Brand::create($request -> except('_token', 'photo'));

            //save translations

          $brands->name = $request->name;
          $brands->photo = getPhotoAttribute($fileName);

           $brands->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم لاضافة بنجاح ']);


    }
/**
    public function edit($id){

        //get specific categories and its translations
      $Category = Category::find($id);

        if(!$Category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

       return view('admin.categories.edit', compact('Category'));

    }

    public function update(MainCategoryRequest $request , $id ){

        try{

            //validation

            //update db
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::orderBy('id', 'DESC')->find($id);
            DB::beginTransaction();
            if(!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

            $category -> update($request -> all());

            //update translations

            $category->name = $request->name;
           $category->save();
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحذيث بنجاح ']);

        }catch(\Exception $ex){
            return redirect()->route('admin.maincategories')->with(['error' => 'حاول لاحقا']);
            DB::rollback();
        }

    }

       public function destroy($id){

        try{

            $Category = Category::find($id);

            if(!$Category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

            $Category -> delete();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحذف بنجاح ']);

        }catch(\Exception $ex){
            return redirect()->route('admin.maincategories')->with(['error' => 'حاول لاحقا']);
        }
       }
 * **/

  //  public function changeStatus(){}


}
