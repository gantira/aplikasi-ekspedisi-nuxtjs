<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //RULE HEADERSNYA HARUS KITA SET SECARA SPESIFIK SEPERTI INI 
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        ];

        //TAPI JIKA METHOD YANG MASUK ADALAH OPTIONS
        if ($request->isMethod('OPTIONS')) {
            //MAKA KITA KEMBALIKAN BAHWA METHOD TERSEBUT ADALAH OPTIONS
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        //SELAIN ITU, KITA AKAN MENERUSKAN RESPONSE SEPERTI BIASA DENGAN MENGIKUT SERTAKAN HEADERS YANG SUDAH DITETAPKAN.
        $response = $next($request);
        foreach ($headers as $key => $row) {
            $response->header($key, $row);
        }
        return $response;
    }
}
