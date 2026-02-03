<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCLientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCLientRequest $request)
    {
        $data = $request->validated();

        try {
            $client = new Client();
            $client->fill($data);
            $client->save();
        } catch (\Exception $th) {
            return response()->json(['message' => 'falha ao salvar'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
