<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MachineComplex;

class MachinesController extends Controller
{
    public function index(Request $request)
    {
        $machines = auth()->user()->machines()->orderBy('created_at', 'desc')->paginate(10);

        return succeed(['machines' => MachineComplex::collection($machines)]);
    }
}
