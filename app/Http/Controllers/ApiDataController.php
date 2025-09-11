<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiData;

class ApiDataController extends Controller
{
    public function store(Request $request)
    {
        $record = ApiData::create([
            'module'  => $request->input('module'),
            'payload' => $request->input('payload'),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $record
        ]);
    }
}