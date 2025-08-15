<?php

namespace App\Http\Controllers;

use App\Models\NewLetter;
use Illuminate\Http\Request;

class GetMailController extends Controller
{
    public function get()
    {
        $get = NewLetter::select(['id', 'email'])->get();
        if(!$get) {
            return response()->json(['message' => 'No emails found'], 404);
        }
        return response()->json($get);
    }
}
