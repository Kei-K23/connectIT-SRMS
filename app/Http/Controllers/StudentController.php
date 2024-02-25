<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $section = $user->student->section;

        return view('dashboard.student.index', ['section' => $section]);
    }
}
