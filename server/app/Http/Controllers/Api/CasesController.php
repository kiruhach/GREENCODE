<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectCase;
use Illuminate\Http\Request;

class CasesController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectCase::orderBy('created_at', 'desc');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $case = ProjectCase::findOrFail($id);
        return response()->json($case);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'tags' => 'nullable|array',
            'category' => 'nullable|string',
            'full_description' => 'nullable|string',
            'result' => 'nullable|string',
            'task' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|array',
        ]);

        $case = ProjectCase::create($data);
        return response()->json($case, 201);
    }

    public function update(Request $request, $id)
    {
        $case = ProjectCase::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'tags' => 'nullable|array',
            'category' => 'nullable|string',
            'full_description' => 'nullable|string',
            'result' => 'nullable|string',
            'task' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|array',
        ]);

        $case->update($data);
        return response()->json($case);
    }

    public function destroy($id)
    {
        ProjectCase::findOrFail($id)->delete();
        return response()->json(['message' => 'Кейс удалён.']);
    }
}
