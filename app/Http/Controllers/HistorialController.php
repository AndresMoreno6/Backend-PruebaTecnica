<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Services\CambioMonedaService;
use Illuminate\Http\Request;

class HistorialController
{
    /**
     * Display a listing of the resource.
     */
    protected $cambioMonedaService;

    public function __construct(CambioMonedaService $cambioMonedaService)
    {
        $this->cambioMonedaService = $cambioMonedaService;
    }

    public function getCambio(Request $request)
    {
        $base = 'COP';
        $targets = 'GBP';
        $rate = $this->cambioMonedaService->cambioMoneda($base, $targets);
        return response()->json([$rate]);


    }




    public function index()
    {
        //
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
    public function show(Historial $historial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historial $historial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historial $historial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historial $historial)
    {
        //
    }
}
