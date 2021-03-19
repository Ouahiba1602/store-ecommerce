<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $fillable = ['parent_id', 'is_active', 'photo'];

    protected $hidden = ['translations'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActive(){
        return $this-> is_active == 0 ? 'غير مفعل' : 'مفعل';
    }

    public function getPhotoAttribute($val){
        return ($val !== null) ? asset('assets/images/brands/' .$val) : "";
    }


}
