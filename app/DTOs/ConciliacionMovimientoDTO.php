<?php

namespace App\DTOs;

class ConciliacionMovimientoDTO
{
    private $cedulaPagador;
    private $telefonoPagador;
    private $telefonoDestino;
    private $referencia;
    private $fechaPago;
    private $importe;
    private $bancoOrigen;

    public function __construct($cedulaPagador, $telefonoPagador, $telefonoDestino, $referencia, $fechaPago, $importe, $bancoOrigen)
    {
        $this->cedulaPagador = $cedulaPagador;
        $this->telefonoPagador = $telefonoPagador;
        $this->telefonoDestino = $telefonoDestino;
        $this->referencia = $referencia;
        $this->fechaPago = $fechaPago;
        $this->importe = $importe;
        $this->bancoOrigen = $bancoOrigen;
    }

    public function toArray()
    {
        return [
            'cedulaPagador' => $this->cedulaPagador,
            'telefonoPagador' => $this->telefonoPagador,
            'telefonoDestino' => $this->telefonoDestino,
            'referencia' => $this->referencia,
            'fechaPago' => $this->fechaPago,
            'importe' => $this->importe,
            'bancoOrigen' => $this->bancoOrigen,
        ];
    }

    // Métodos getter y setter para cada propiedad, si son necesarios
}
