<?php
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
        } else {
            return 'CERTIFICADO';
        }
    }

    private function getPayments($clientId)
    {
        return HistorialPagos::where('cliente_id', $clientId)
            ->where('estatus_pago', 'pagado')
            ->count();
    }

    private function getPendingPayments($clientId)
    {
        return HistorialPagos::where('cliente_id', $clientId)
            ->where('estatus_pago', 'pendiente')
            ->count();
    }

    private function getOverduePayments($clientId)
    {
        return HistorialPagos::where('cliente_id', $clientId)
            ->where('estatus_pago', 'en_mora')
            ->count();
    }
}

class ClientController extends Controller
{
    public function updateLevel(Request $request)
    {
        // Obtén el ID del cliente
        $clientId = $request->input('client_id');

        // Calcula el nivel del cliente
        $calculator = new ClientLevelCalculator();
        $level = $calculator->calculate($clientId);

        // Obtén el cliente a partir de su ID
        $client = Client::find($clientId);

        // Actualiza el nivel del cliente
        $client->level = $level;

        // Guarda los cambios en la base de datos
        $client->save();

        // Redirige al usuario a la vista de información del cliente
        return redirect()->route('client.info', ['id' => $clientId]);
    }
}
