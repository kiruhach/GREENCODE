<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('file')->store('case-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        $path = str_replace(asset('storage/'), '', $request->url);
        $fullPath = storage_path('app/public/' . $path);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        return response()->json(['message' => 'Изображение удалено.']);
    }
}
