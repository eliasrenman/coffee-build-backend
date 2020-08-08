<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Carbon;

class EidController extends Controller
{
    public function update(Request $request)
    {
        $id = $request->user->id;
        $user = \App\User::find($id);
        $user->eid = Hashids::encode(floor(Carbon::now()->timestamp / 2) . $id . rand(0, 10));
        $user->save();
        return $user;
    }
}
