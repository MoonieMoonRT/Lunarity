<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('welcome', compact('roomTypes'));
    }
}
