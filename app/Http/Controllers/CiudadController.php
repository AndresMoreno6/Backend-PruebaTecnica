<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController
{

    public function ciudadesPorPais($paisId)
    {
        return Ciudad::where('pais_id', $paisId)->get();
    }

}
