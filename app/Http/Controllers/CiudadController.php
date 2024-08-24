<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Ciudad::all();
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
    public function show($paisId)
    {
        return Ciudad::where('pais_id', $paisId)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ciudad $ciudad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ciudad $ciudad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciudad $ciudad)
    {
        //
    }
}
