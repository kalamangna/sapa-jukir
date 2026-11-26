<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitUsaha;

class UnitUsahaHistoryController extends Controller
{
    public function index(UnitUsaha $unitUsaha)
    {
        $histories = $unitUsaha->histories()->with('diubahOleh')->latest()->paginate(20);
        return view('admin.unit-usaha.history', compact('unitUsaha', 'histories'));
    }
}