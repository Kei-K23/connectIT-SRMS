<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function  index(): View
    {
        return view("dashboard.instructor.index");
    }
}
