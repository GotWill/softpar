<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandRequest;
use App\Http\Requests\UpdateDemandRequest;
use App\Http\Requests\UpdateDemandStatusRequest;
use App\Http\Resources\DemandResource;
use App\Models\Demand;

class DemandController extends Controller
{
    public function index()
    {
        $demands = Demand::where('is_deleted', false)
            ->whereHas('client', function ($query) {
                $query->where('is_deleted', false);
            })
            ->get();

        return response(DemandResource::collection($demands), 200);
    }
    public function store(StoreDemandRequest $request)

    {
        $data = $request->validated();

        try {
            $demand = new Demand();
            $demand->fill($data);
            $demand->save();
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error saving to database.'], 400);
        }
    }


    public function update(UpdateDemandRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $demand = Demand::findOrFail($id);
            $demand->update($data);
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error update to database.'], 400);
        }
    }

    public function updateStatus(UpdateDemandStatusRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $demand = Demand::findOrFail($id);
            $demand->update($data);
        } catch (\Exception $th) {
            return response()->json(['message' => 'Error update status to database.'], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $demand = Demand::findOrFail($id);
            $demand->is_deleted = true;
            $demand->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error delete demand to database.'], 400);
        }
    }
}
