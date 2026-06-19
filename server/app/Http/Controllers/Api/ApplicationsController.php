<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function index()
    {
        return response()->json(Application::orderBy('created_at', 'desc')->get());
    }

    public function show($id)
    {
        return response()->json(Application::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'message' => 'nullable|string',
            'task_details' => 'nullable|string',
            'timeframe' => 'nullable|string',
            'budget' => 'nullable|string',
            'contact_format' => 'nullable|string',
            'services' => 'nullable|array',
        ]);

        $data['status'] = 'new';

        return response()->json(Application::create($data), 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string|in:new,in_progress,done']);

        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);

        return response()->json($application);
    }

    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return response()->json(['message' => 'Заявка удалена.']);
    }
}
