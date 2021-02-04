<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
{
    public function editShippingMethods($type)
    {
        //free, inner, outer

        if ($type == 'free') {
            $shippingMethod = Setting::Where('key', 'free_shipping_label')->first();
        } elseif ($type == 'inner') {
            $shippingMethod = Setting::Where('key', 'local_label')->first();
        } elseif ($type == 'outer') {
            $shippingMethod = Setting::Where('key', 'outer_label')->first();
        } else {
            $shippingMethod = Setting::Where('key', 'free_shipping_label')->first();
        }
        return view('admin.settings.shippings.edit', compact('shippingMethod'));

    }


        public function updateShippingMethods(ShippingsRequest $request, $id)
        {
            //Validation

            //update db
         try{

             $shipping_method = Setting::find($id);

             DB::beginTransaction();
             $shipping_method -> update(['plain_value' => $request -> plain_value]);

             //save translations
             $shipping_method -> value = $request -> value ;
             $shipping_method -> save() ;
              DB::commit();
             return redirect() -> back() ->with(['success' => 'تم التعديل بنجاح']);
         }
         catch(\Exception $ex){
             return redirect() -> back() ->with(['error' => 'هناك خطا و حاول مجددا']);
             DB::rollback();
         }

        }

}
