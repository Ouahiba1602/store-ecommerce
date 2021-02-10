<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use app\Models\Admin;
use app\Http\Requests;
class ProfileController extends Controller
{
    public function editProfile(){


        $admin = Admin::find(auth('admin') -> user() -> id);

        return view('admin.profile.edit', compact('admin'));
    }

    public function updateProfile(ProfileRequest $request){

        //validation

        //db process

        try{
            $admin = Admin::find(auth('admin') -> user() ->id );


            if($request->filled('password')){
                 $request->merge(['password' => bcrypt($request->password)]);
        }
            unset($request['id']);
            unset($request['password_confirmation']);
            $admin -> update($request -> all());

            return redirect() -> back() ->with(['success' => 'تم التعديل بنجاح']);

        }catch (Exception $ex){

            return redirect() -> back() ->with(['error' => 'هناك خطا و حاول مجددا']);
        }
    }



}
