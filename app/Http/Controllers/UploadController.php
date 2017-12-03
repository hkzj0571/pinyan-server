<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function token()
    {
        return succeed(['token' => \Storage::disk('qiniu')->getUploadToken()]);
    }
}
