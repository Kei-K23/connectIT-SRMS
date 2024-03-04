<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function  index(Request $request): View
    {
        $user = $request->user();
        $materials = $user->instructor->section->materials()->orderBy('created_at', 'desc')->get();

        return view("dashboard.instructor.index", ['user' => $user, 'materials' => $materials]);
    }
}
