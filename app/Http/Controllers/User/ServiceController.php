<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServiceNumber;

class ServiceController extends Controller
{
    public function index()
    {
        $services = ServiceNumber::orderBy('id')->get();
        return view('user.services', compact('services'));
    }
}
