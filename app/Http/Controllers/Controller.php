<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
*      version="1.0",
*      title="'Satisfaction Client' API Documentation",
*      description="API Documentation for 'Satisfaction Client' Project"
* )
*/
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
