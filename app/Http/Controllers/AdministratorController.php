<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdministratorController extends Controller
{
    public function index(): View
    {
        return view('dashboard.admin.index');
    }

    public function addStudent(): View
    {
        return view('dashboard.admin.add-student');
    }
}
