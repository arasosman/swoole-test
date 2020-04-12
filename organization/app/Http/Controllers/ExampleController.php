<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test(Request $request)
    {
        $response = Http::withHeaders(['Authorization'=> $request->header('Authorization')])->get('http://192.168.1.163:85/security/example');
        return $response->body();
    }
}
