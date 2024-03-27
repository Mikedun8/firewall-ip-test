<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GeoIp2\WebService\Client;
use Illuminate\Support\Facades\Log;

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
            // Obtener la dirección IP del cliente en produccion
            // Para probar metodos en local asignar manualmente la ip publica
            $response_array_ip = $request->headers->all();
            $ip = $response_array_ip["do-connecting-ip"][0];

            // print("esta es mi ip pública: " . $ip);

            // Creación del cliente de MaxMind para usar los servicios de geolocation
            $client = new Client(992235, env('MAXMINDKEY'), ['en'], ['host' => 'geolite.info']);
            
            $record = $client->country($ip);
            //dd($record->country->isoCode);

            // Verificar si el país de la dirección IP es México o Estados Unidos
            if ($record->country->isoCode === 'MX' || $record->country->isoCode === 'US') {
                // Permitir el acceso a la ruta
                return $next($request);
            }
        } catch (\Throwable $e) {
            // Manejar cualquier error o excepción que ocurra durante la consulta
            Log::error('Error processing GeoLocation: ' . $e->getMessage());
            //dd($e->getMessage());
        }

        // Denegar el acceso a la ruta
        return redirect()->route('access_denied');
    }
}
