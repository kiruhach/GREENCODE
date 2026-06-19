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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'icon' => 'nullable|string',
            'sub_items' => 'nullable|array',
            'sort_order' => 'nullable|integer',
        ]);

        return response()->json(Service::create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'icon' => 'nullable|string',
            'sub_items' => 'nullable|array',
            'sort_order' => 'nullable|integer',
        ]);

        $service->update($data);
        return response()->json($service);
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return response()->json(['message' => 'Услуга удалена.']);
    }
}
