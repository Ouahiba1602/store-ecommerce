<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['value'];

    protected $fillable = ['key', 'is_translatable', 'plain_value'];

    protected $casts = [
        'is_translatable' => 'boolean',
    ];

    /**
     *set the given Settings
     *
     * @param array $settings
     * @return void
     */

     public static function setMany($settings){

         foreach ($settings as $key => $value){
             self::set($key, $value);
         }
     }

    /**
     *set the given Settings
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */

     public static function set($key, $value){

         if ($key == 'translatable'){

             return static::setTranslatableSettings($value);

         }
            if(is_array($value))
            {
                $value = json_encode($value);
            }
         static::updateOrCreate(['key' => $key], ['plain_value' => $value]);
     }

    /**
     *set the translatable Settings
     *
     * @param string $settings
     * @return void
     */

    public static function setTranslatableSettings($settings = []){

        foreach ($settings as $key => $value){
            static::updateOrCreate(['key' => $key],[
               'is_translatable' => true,
               'value' => $value,
            ]);
            }
        }


}
