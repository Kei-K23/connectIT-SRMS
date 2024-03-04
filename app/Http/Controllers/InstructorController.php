<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function  index(Request $request): View
    {
        $user = $request->user();
        return view("dashboard.instructor.index", ['user' => $user]);
    }
}
