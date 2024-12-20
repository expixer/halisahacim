<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StadiumRequest;
use App\Http\Resources\StadiumCollection;
use App\Http\Resources\StadiumResource;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return StadiumCollection
     */
    public function index()
    {
        return new StadiumCollection(Stadium::with(['firm', 'comments', 'favoriteStadiums', 'images'])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StadiumRequest $request)
    {
        return response(Stadium::create($request->validated()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Stadium $stadium
     * @return StadiumResource
     */
    public function show($stadium)
    {
        $stadium = Stadium::with(['firm', 'comments', 'favoriteStadiums', 'images'])->find($stadium);

        return new StadiumResource($stadium);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StadiumRequest $request, $id): \Illuminate\Http\Response
    {
        return response(Stadium::query()->find($id)->update($request->validated()), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
