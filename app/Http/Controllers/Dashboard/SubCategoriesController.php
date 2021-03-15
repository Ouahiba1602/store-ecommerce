<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    public function index(){
         $categories = Category::child() ->  orderBy('id', 'DESC') -> paginate(PAGINATION_COUNT);
       return view('admin.subcategories.index', compact('categories') );
    }

   public function create(){
        $categories = Category::parent()->orderBy('id', 'DESC')-> paginate(PAGINATION_COUNT);
        return view('admin.subcategories.create' ,compact('categories'));
    }


    public function store(SubCategoryRequest $request){


        try{

            //validation

            //update db

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            DB::beginTransaction();

          $category = Category::create($request -> except('_token'));

            //update translations

          $category->name = $request->name;

           $category->save();
            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم لاضافة بنجاح ']);

        }catch(\Exception $ex){
            return redirect()->route('admin.subcategories')->with(['error' => 'حاول لاحقا']);
            DB::rollback();
        }
    }

    public function edit($id){

        //get specific categories and its translations
      $Category = Category::find($id);

        if(!$Category)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);

        $categories = Category::parent()->orderBy('id', 'DESC')-> paginate(PAGINATION_COUNT);
        return view('admin.subcategories.edit', compact('Category', 'categories'));

    }

    public function update(SubCategoryRequest$request , $id ){

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
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

            $category -> update($request -> all());

            //update translations

            $category->name = $request->name;
           $category->save();
            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم التحذيث بنجاح ']);

        }catch(\Exception $ex){
            return redirect()->route('admin.subcategories')->with(['error' => 'حاول لاحقا']);
            DB::rollback();
        }

    }

       public function destroy($id){

        try{

            $Category = Category::find($id);

            if(!$Category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);

            $Category -> delete();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم الحذف بنجاح ']);

        }catch(\Exception $ex){
            return redirect()->route('admin.subcategories')->with(['error' => 'حاول لاحقا']);
        }
       }

  //  public function changeStatus(){}


}
