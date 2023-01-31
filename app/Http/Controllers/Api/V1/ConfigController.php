<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'image' => config('const.image'),
            'select' => config('const.select'),
        ]);
    }
}