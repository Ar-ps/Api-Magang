<?php

namespace App\Http\Controllers;

use App\Models\ScrapOutExternal;
use Illuminate\Http\Request;

class ScrapOutExternalController extends Controller
{
    public function index()
    {
        $scrapOutExternals = ScrapOutExternal::with('items')->get();
        return view('scrap_out_external.index', compact('scrapOutExternals'));
    }

    public function create()
    {
        return view('scrap_out_external.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'scrap_out_external_number' => 'required|string|unique:scrap_out_externals',
            'scrap_out_external_date'   => 'required|date',
            'transaction_type'          => 'required|string',
            'items'                     => 'required|array',
            'items.*.item_code'         => 'required|string',
            'items.*.item_quantity'     => 'required|integer',
        ]);

        // Simpan header
        $scrapOutExternal = ScrapOutExternal::create($request->only([
            'scrap_out_external_number',
            'scrap_out_external_date',
            'transaction_type',
            'receiver_entity_code',
            'currency_code',
            'decree_number',
            'decree_date',
            'entry_date',
            'confirmation_status',
            'confirmation_date',
            'confirmation_id',
        ]));

        // Simpan detail
        foreach ($request->items as $item) {
            $scrapOutExternal->items()->create($item);
        }

        return redirect()->route('scrap_out_external.index')->with('success', 'Scrap Out External created successfully.');
    }

    public function show(ScrapOutExternal $scrapOutExternal)
    {
        $scrapOutExternal->load('items');
        return view('scrap_out_external.show', compact('scrapOutExternal'));
    }
}
