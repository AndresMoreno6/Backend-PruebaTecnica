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
    public function index()
    {
        // return Pais::with([
        //     'ciudades' => function ($query) {
        //         $query->limit(2);
        //     }
        // ])->get();

        return Pais::all();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pais = Pais::find($id);

        if ($pais) {
            return response()->json($pais);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pais $pais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pais $pais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pais $pais)
    {
        //
    }
}
