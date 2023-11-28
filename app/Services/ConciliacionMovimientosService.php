<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTOs\ConciliacionMovimientoDTO;

class ConciliacionMovimientosService 
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.conciliacion_movimientos.base_url');
        $this->apiKey = config('services.conciliacion_movimientos.api_key');
    }

    public function enviar(ConciliacionMovimientoDTO $dto): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Key' => $this->apiKey
        ])->post($this->baseUrl . '/getMovement', $dto->toArray());

        return $response->json();
    }
}




