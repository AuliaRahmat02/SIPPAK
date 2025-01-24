<?php

namespace App\Http\Controllers;

use App\Models\fileModel;
use App\Http\Requests\StorefileModelRequest;
use App\Http\Requests\UpdatefileModelRequest;

class FileModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorefileModelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(fileModel $fileModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(fileModel $fileModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefileModelRequest $request, fileModel $fileModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fileModel $fileModel)
    {
        //
    }
}
