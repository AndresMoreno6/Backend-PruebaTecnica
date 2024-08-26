<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class HistorialController
{

    public function cambioMoneda(Request $request)
    {
        $presupuesto = $request->input('amount');
        $divisa = $request->input('currency');
        $apiKey = env('FIXER_API_KEY');
        $response = Http::withHeaders([
            'apikey' => $apiKey
        ])->get('https://api.apilayer.com/fixer/convert', [
                    'to' => $divisa,
                    'from' => 'COP',
                    'amount' => $presupuesto
                ]);

        if ($response->successful()) {
            $cambio = $response->json()['result'];
            $tasaCambio = $response->json()['info']['rate'];

            return response()->json(['currency' => $divisa, 'converted' => $cambio, 'rate' => $tasaCambio]);
        } else {
            return response()->json(['error' => 'Error al obtener las tasas de cambio'], 500);
        }
    }

    public function obtenerClima(Request $request)
    {
        $ciudad = $request->input('ciudad');
        $apiKey = env('OPENWEATHER_API_KEY');  // Asegúrate de tener la API key en tu archivo .env
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


    public function store(Request $request)
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
        $presupuestoLocal = (int)$conversionData->converted;

        // Crear un nuevo registro de historial
        $historial = Historial::create([
            'pais_id' => $validated['pais_id'],
            'ciudad_id' => $validated['ciudad_id'],
            'presupuesto_cop' => $validated['presupuesto_cop'],
            'presupuesto_local' => $presupuestoLocal,
            'clima' => $temperatura,  // Temperatura en grados Celsius
            'fecha' => now()->toDateString(),  // Formato YYYY-MM-DD
        ]);

        return response()->json($historial, 201);
    }

}
