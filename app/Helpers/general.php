<?php

namespace App\Helpers;

 function getFolder(){
    return app() -> getLocale() == 'ar' ? 'css-rtl' : 'css';
}















