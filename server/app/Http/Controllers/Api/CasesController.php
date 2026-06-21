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
}
