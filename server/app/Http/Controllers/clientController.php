<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCLientRequest;
use App\Http\Requests\UpdateCLientRequest;
use App\Models\Client;
use Exception;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user = Client::all();
         return response()->json($user->toResourceCollection());
    }

    public function store(StoreCLientRequest $request)
    {
        $data = $request->validated();

        try {
            $client = new Client();
            $client->fill($data);
            $client->save();
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error saving to database.'], 400);
        }
    }

    public function update(UpdateCLientRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $client = Client::findOrFail($id);
            $client->update($data);
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error update to database.'], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
           $isRemoved = Client::destroy($id);

           if(!$isRemoved){
            throw new Exception();
           }
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error delete user to database.'], 400);
        }
    }
}
