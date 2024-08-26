<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class HistorialController
{

    //Funcion para realizar el cambio de moneda
    public function cambioMoneda(Request $request)
    {
        $presupuesto = $request->input('amount');
        $divisa = $request->input('currency');
        $apiKey = env('FIXER_API_KEY');

        $response = Http::withHeaders([
            'apikey' => $apiKey
        ])->get('https://api.apilayer.com/currency_data/convert', [
            'to' => $divisa,
            'from' => 'COP',
            'amount' => $presupuesto
        ]);

        if ($response->successful()) {
            $cambio = $response->json()['result'];
            $tasaCambio = $response->json()['info']['quote'];

            return response()->json(['currency' => $divisa, 'converted' => $cambio, 'quote' => $tasaCambio]);
        } else {
            return response()->json(['error' => 'Error al obtener las tasas de cambio'], 500);
        }
    }

    //Funcion para obtener el clima de la ciudad eligida
    public function obtenerClima(Request $request)
    {
        $ciudad = $request->input('ciudad');
        $apiKey = env('OPENWEATHER_API_KEY');  //la API key en tu archivo .env
        $client = new Client();
        $response = $client->get('http://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'q' => $ciudad,
                'appid' => $apiKey,
                'units' => 'metric',    // Temperatura en grados Celsius
                'lang' => 'es',         // Descripción en español (opcional)
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);
            $temperatura = $data['main']['temp'];  // Extraer la temperatura en grados Celsius

            return response()->json(['temperatura' => $temperatura]);
        } else {
            return response()->json(['error' => 'Error al obtener el clima'], 500);
        }
    }


    //Funcion para guarda las busquedas
    public function guardarBusqueda(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'pais_id' => 'required|exists:pais,id',
            'ciudad_id' => 'required|exists:ciudad,id',
            'presupuesto_cop' => 'required|numeric',
            'moneda' => 'required|string',
        ]);

        // Obtener el clima de la ciudad
        $ciudad = Ciudad::find($validated['ciudad_id']);
        if (!$ciudad) {
            return response()->json(['error' => 'Ciudad no encontrada'], 404);
        }

        $climaRequest = new Request([
            'ciudad' => $ciudad->nombre
        ]);

        $climaResponse = $this->obtenerClima($climaRequest);

        if ($climaResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'Error al obtener el clima'], 500);
        }

        $climaData = $climaResponse->getData();
        $temperatura = $climaData->temperatura;

        // Obtener la tasa de cambio y el monto convertido
        $conversionRequest = new Request([
            'amount' => $validated['presupuesto_cop'],
            'currency' => $validated['moneda']
        ]);

        $conversionResponse = $this->cambioMoneda($conversionRequest);

        if ($conversionResponse->getStatusCode() !== 200) {
            return response()->json(['error' => 'Error al obtener las tasas de cambio'], 500);
        }

        $conversionData = $conversionResponse->getData();
        $presupuestoLocal = $conversionData->converted;
        $divisa = $conversionData->currency;
        $tasaCambio = $conversionData->quote;

        $presupuestoL = Str::of($divisa)->append(' ', $presupuestoLocal);

        // Crear un nuevo registro de historial
        $historial = Historial::create([
            'pais_id' => $validated['pais_id'],
            'ciudad_id' => $validated['ciudad_id'],
            'presupuesto_cop' => $validated['presupuesto_cop'],
            'presupuesto_local' => $presupuestoL,
            'tasa_cambio' => $tasaCambio,
            'clima' => $temperatura,  // Temperatura en grados Celsius
            'fecha' => now()->toDateString(),  // Formato YYYY-MM-DD
        ]);

        return response()->json($historial, 201);
    }


    //Funcion para obtener una sola busqueda
    public function obtenerHistorial($id)
    {
        $historial = Historial::find($id);
        return response()->json($historial);
    }


    //Funcion para obtener las ultimas 5 busquedas
    public function historialBusquedas()
    {
        $historial = Historial::with(['pais', 'ciudad'])->latest('id')->take(5)->get();
        return response()->json($historial);
    }

}
