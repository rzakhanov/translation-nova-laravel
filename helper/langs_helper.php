<?php


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

if (!function_exists('supported_langs')) {
    function supported_langs(): Collection
    {
        return collect(config('rzakhanov-translation.languages'))->mapWithKeys(function($description, $index){
            if( File::isDirectory(config('rzakhanov-translation.lang_path').'/'.$index)){
                return [$index => $description];
            }
        });
    }

}
