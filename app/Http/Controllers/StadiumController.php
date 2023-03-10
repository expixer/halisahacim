<?php

namespace App\Http\Controllers;

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
        return new StadiumCollection(
            new StadiumResource(Stadium::all())
        );

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
     * @param \App\Http\Requests\StadiumRequest $request
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
    public function show(Stadium $stadium)
    {
        return new StadiumResource($stadium);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
