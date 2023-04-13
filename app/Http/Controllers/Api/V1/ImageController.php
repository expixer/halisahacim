<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Stadium;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id' => 'required|integer',
            'type' => 'required|string',
        ]);

        $imageableType = Image::getImageableType($request->type);
        $imagePath = $request->file('image')->storeAs('images/' . $request->type, $request->id . '-'. time() . '.jpg', 'public');

        $data = Image::create([
            'path' => $imagePath,
            'imageable_id' => $request->id,
            'imageable_type' => $imageableType,
        ]);

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return response()->json($image->path, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
