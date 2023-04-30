<?php

namespace App\Models;
use App\Models\HistorialPago;
class ClientLevelCalculator
{
    public function calculate($clientId)
    {
        // Obtén el número total de pagos realizados por el cliente
        $payments = $this->getPayments($clientId);

        // Resta 1 punto por cada pago pendiente
        $pendientes = $this->getPendingPayments($clientId);
        $payments -= $pendientes;

        // Resta 5 puntos por cada pago en mora
        $enMora = $this->getOverduePayments($clientId);
        $payments -= 5 * $enMora;

   
        // Calcula el nivel del cliente según el número de pagos o abonos realizados
        if ($payments >= 35) {
            return 'PLATINUM';
        } elseif ($payments >= 22) {
            return 'GOLD';
        } elseif ($payments >= 15) {
            return 'PLATA';
        } elseif ($payments >= 9) {
            return 'BRONCE';
        }  elseif ($payments >=1) {
            return 'CERTIFICADO';
        }else {
            return 'SIN NIVEL';
        }	
    }

    private function getPayments($clientId)
    {
        return HistorialPago::where('customer_id', $clientId)
              ->whereIn('payment_status',[3,4,5,6])
            ->count();
    }

    private function getPendingPayments($clientId)
    {
        return HistorialPago::where('customer_id', $clientId)
            ->where('payment_status', 3)
            ->count();
    }

    private function getOverduePayments($clientId)
    {
        return HistorialPago::where('customer_id', $clientId)
            ->where('payment_status', 4)
            ->count();
    }
}
