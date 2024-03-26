<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GeoIp2\WebService\Client;

class CheckGeoLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Obtener la dirección IP del cliente
            $ip = $request->ip();
            print("esta es mi ip: " . $ip);
            $client = new Client(10, env('MAXMINDKEY'));

            $record = $client->country($ip);

            print($record->country->isoCode . "\n");

            // Verificar si el país de la dirección IP es México o Estados Unidos
            if ($record->country->isoCode === 'MX' || $record->country->isoCode === 'US') {
                // Permitir el acceso a la ruta
                return $next($request);
            }
        } catch (\Throwable $e) {
            // Manejar cualquier error o excepción que ocurra durante la consulta
            \Log::error('Error processing GeoLocation: ' . $e->getMessage());
        }


        // Denegar el acceso a la ruta
        $ip = $request->ip();
            dd("esta es mi ip: " . $ip);
        return redirect()->route('access.denied');
    }
}
