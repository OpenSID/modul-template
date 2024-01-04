<?php

use Modules\Contoh\Models\Agama;

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