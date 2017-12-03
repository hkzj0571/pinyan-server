<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarsController extends Controller
{
    public function index(Request $request)
    {
        return succeed(['avatars' => Avatar::nasty()->get()]);
    }
}
