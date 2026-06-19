<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        return response()->json(Review::orderBy('created_at', 'desc')->get());
    }

    public function latest(Request $request)
    {
        $limit = $request->input('limit', 2);
        return response()->json(Review::orderBy('created_at', 'desc')->take($limit)->get());
    }

    public function show($id)
    {
        return response()->json(Review::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'text' => 'required|string',
            'initials' => 'nullable|string|max:10',
        ]);

        return response()->json(Review::create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'role' => 'nullable|string|max:255',
            'text' => 'sometimes|string',
            'initials' => 'nullable|string|max:10',
        ]);

        $review->update($data);
        return response()->json($review);
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return response()->json(['message' => 'Отзыв удалён.']);
    }
}
