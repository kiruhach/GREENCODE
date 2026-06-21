<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return response()->json(Service::orderBy('sort_order')->get());
    }

    public function show($id)
    {
        return response()->json(Service::findOrFail($id));
    }

    public function details($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service->details()->orderBy('sort_order')->get());
    }

    public function allDetails()
    {
        $details = \App\Models\ServiceDetail::orderBy('sort_order')->get();
        return response()->json($details);
    }
}
