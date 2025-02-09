<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "API Documentation", title: "API Documentation"),
    OA\Server(url: 'http://127.0.0.1:8000/api', description: 'local server'),
    OA\SecurityScheme( securityScheme: 'bearerAuth', type: 'http', name: 'Authorization', in: 'header', scheme: 'bearer' ),
]

abstract class Controller
{
    //
}
