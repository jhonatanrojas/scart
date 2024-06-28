<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'recipient' => 'required|email',
            'content' => 'required|string',
        ]);

        $recipient = $request->input('recipient');
        $content = $request->input('content');

        // Configurar los datos del correo
        $details = [
            'title' => 'Correo de prueba',
            'body' => $content
        ];

        // Enviar el correo
        Mail::send('emails.test', $details, function($message) use ($recipient) {
            $message->to($recipient)
                    ->subject('Correo de prueba');
        });

        return response()->json(['message' => 'Correo enviado con éxito']);
    }
}
