<?php

namespace App\Http\Controllers;

use App\Http\Requests\TutorialRequest;
use App\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        return Tutorial::all();
    }

    public function show($id)
    {
        return Tutorial::find($id);
    }

    public function store(TutorialRequest $request)
    {
        return Tutorial::create($request->all());
    }

    public function test()
    {
        return collect(range(0, 40000))
            ->filter(function ($item) {
                return $item % 2 === 0 ? $item : false;
            })
            ->map(function ($item) {
                return $item * 2;
            })->count();
    }
}
