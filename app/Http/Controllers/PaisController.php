<?php

namespace App\Http\Controllers;

// use App\Models\Ciudad;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController
{
    /**
     * Display a listing of the resource.
     */
    public function paises()
    {
        return Pais::all();
    }

    public function paisPorId($id)
    {
        $pais = Pais::find($id);

        if ($pais) {
            return response()->json($pais);
        }
    }

}
