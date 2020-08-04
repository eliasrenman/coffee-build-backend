<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $id = $request->user->id;
        $user = \App\User::find($id);
        $user->uuid = Hashids::encode(floor(Carbon::now()->timestamp / 2) . $id . rand(0, 10));
        $user->save();
        return $user;
    }
}
