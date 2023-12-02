<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\TipoCambioBcv;
use SCart\Core\Front\Models\ShopCurrency;

class DollarExchangeController extends Controller
{
    public function getUsdExchangeRate()
    {

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://pydolarvenezuela-api.vercel.app/api/v1/dollar/page?page=bcv');
            $data = json_decode($response->getBody(), true);

            $usdData = $data['monitors']['usd'] ?? null;

            dd($usdData);
            if ($usdData) {
                return response()->json([
                    'success' => true,
                    'usd' => $usdData
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No USD data found'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function actualizaTasa()
    {

        $client = new Client();
        $response = $client->request('GET', 'https://pydolarvenezuela-api.vercel.app/api/v1/dollar/page?page=bcv');
        $data = json_decode($response->getBody(), true);

        $usdData = $data['monitors']['usd'] ?? null;

        $fecha = date('Y-m-d');

        $data_pago = [
            'valor' => $usdData['price'] ?? 1,
            'moneda' => 'USD',
            'fecha' =>  $fecha,


        ];


        $tipo_cambio = TipoCambioBcv::where('fecha',  $fecha)->first();



        if ($tipo_cambio == null) {
            TipoCambioBcv::create($data_pago);
        } else {
            TipoCambioBcv::where('id', $tipo_cambio->id)
                ->update($data_pago);
        }

        //  exchange_rate
        $currency = ShopCurrency::Where('code', 'Bs')->update([
            'exchange_rate' => $usdData['price'],

        ]);
    }
}
