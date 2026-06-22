<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        return response()->json(
            Review::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function latest(Request $request)
    {
        $limit = $request->input('limit', 2);
        return response()->json(
            Review::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get()
        );
    }

    public function show($id)
    {
        $review = Review::where('id', $id)->where('status', 'approved')->firstOrFail();
        return response()->json($review);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:30',
            'role' => 'nullable|string|max:255',
            'text' => 'required|string',
            'initials' => 'nullable|string|max:10',
        ]);

        $data['status'] = 'pending';

        return response()->json(Review::create($data), 201);
    }
}
