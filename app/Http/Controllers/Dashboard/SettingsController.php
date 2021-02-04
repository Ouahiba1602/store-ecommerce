<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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


        public function updateShippingMethods(Request $request, $id)
        {
            return $request;
        }

}
