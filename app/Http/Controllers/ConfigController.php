<?php

namespace App\Http\Controllers;

use App\Models\UserConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function store(Request $request)
    {
        $config = UserConfig::create($request->all());

        return redirect('/new-config-confirm')->with('success', 'Config saved!');
    }
}
