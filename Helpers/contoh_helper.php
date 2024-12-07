<?php

use Modules\Template\Models\Agama;

if (! function_exists('contoh')) {
    /**
     * contoh
     *
     * @return array
     */
    function contoh()
    {
        return Agama::get()->toArray();
    }
}