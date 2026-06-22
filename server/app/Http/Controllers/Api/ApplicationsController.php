<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company' => 'nullable|string',
            'message' => 'nullable|string',
            'task_details' => 'nullable|string',
            'timeframe' => 'nullable|string',
            'budget' => 'nullable|string',
            'contact_format' => 'required|string',
            'services' => 'required|array|min:1',
        ]);

        $data['status'] = 'new';

        return response()->json(Application::create($data), 201);
    }
}
