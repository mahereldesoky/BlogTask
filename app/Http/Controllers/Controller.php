<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version:"1.0.0",description:"Blog Post and Comment API",title:"Blog Post and Comment API Documentation"),
    OA\Server(url: 'http://127.0.0.1:8000/api',description:"Local Server "),
    OA\Server(url: "http://staging.example.com",description: "Staging server"),
    OA\Server(url: "http://example.com",description: "Production server"),
   
    
]

abstract class Controller
{
    //
}
    // OA\SecurityScheme(securityScheme:'bearerAuth',type:"http", name:"Authorization", in:"header",scheme:"bearer"),
