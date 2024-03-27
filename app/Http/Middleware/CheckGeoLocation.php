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
            $response_array_ip = $request->headers->all();
            $ip = $response_array_ip["do-connecting-ip"][0];

            print("esta es mi ip pública: " . $ip);

            // Creación del cliente de MaxMind para usar los servicios de geolocation
            $client = new Client(992235, env('MAXMINDKEY'));

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
        $ip = $request->ips();
            dd($request->headers->all());
        return redirect()->route('access.denied');
    }
}
