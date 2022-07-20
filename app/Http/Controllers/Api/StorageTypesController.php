<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorageTypeRequest;
use App\Models\StorageType;
use Illuminate\Http\Request;

class StorageTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storageTypes = StorageType::all();

        return response()->json([
            'status' => true,
            'storage_types' => $storageTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorageTypeRequest $request)
    {
        $storageType = StorageType::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Storage type created successfully',
            'storage_type' => $storageType,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StorageType $storageType
     * @return \Illuminate\Http\Response
     */
    public function show(StorageType $storageType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StorageType $storageType
     * @return \Illuminate\Http\Response
     */
    public function edit(StorageType $storageType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StorageType $storageType
     * @return \Illuminate\Http\Response
     */
    public function update(StorageTypeRequest $request, StorageType $storageType)
    {
        $storageType->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Storage type updated successfully',
            'storage_type' => $storageType,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StorageType $storageType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StorageType $storageType)
    {
        $storageType->delete();

        return response()->json([
            'status' => true,
            'message'=> 'Storage type deleted successfully',
         ], 200);
    }
}
