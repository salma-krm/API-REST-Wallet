<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{
    public function index()
    {
       return response()->json(['message' => 'Hello, World!']);

    }
    public function getData()
    {
       $getData = DB::table('transactions')->get();
       return response()->json(['message' => $getData]);

    }
    
}
