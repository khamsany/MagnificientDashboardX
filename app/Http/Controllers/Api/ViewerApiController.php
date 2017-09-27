<?php

namespace App\Http\Controllers\Api;

use App\Models\Repository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewerApiController extends Controller
{
    public function info(Request $request)
    {
        $data = User::where('id', $request->user()->id)
            ->withIdentity()
            ->firstOrFail();

        return response()->json($data);
    }
}
