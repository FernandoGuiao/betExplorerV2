<?php

namespace App\Http\Controllers;

use App\Models\UserConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function store(Request $request)
    {
        try {
            $config = UserConfig::create($request->all());

            return response()->json($config, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
