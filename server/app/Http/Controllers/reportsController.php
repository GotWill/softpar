<?php

namespace App\Http\Controllers;

use App\Http\Resources\DemandResource;
use App\Models\Demand;
use Symfony\Component\HttpFoundation\Request;

class reportsController extends Controller
{
    public function index(Request $request, $id)
    {
        $request->validate(['month' => 'required|date_format:Y-m']);
        $month = $request->query('month');
        [$year, $monthNumber] = explode('-', $month);
    
        $demands = Demand::with('client') 
            ->where('client_id', $id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNumber)
            ->where('is_deleted', false)
            ->get();
    
    
        return response()->json(DemandResource::collection($demands),200);
    }
}
