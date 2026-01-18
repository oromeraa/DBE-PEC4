<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Museum;

class MuseumController extends Controller
{
    public function index()
    {
        $realMuseums = Museum::whereIn('id', [1,2])->get();

        $fakeMuseums = Museum::whereNotIn('id', [1,2])->inRandomOrder()->take(3)->get();

        $museums = $realMuseums->concat($fakeMuseums);

        return view('welcome', compact('museums'));
    }

    // public function show(Museum $id)
    // {
    //     $museum = Museum::findOrFail($id);
    //     return view('museum_detail', compact('museum'));
    // }
    
}
