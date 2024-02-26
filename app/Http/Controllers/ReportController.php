<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $section = $user->student->section;
        $course = $section->course;

        $reports = Report::where('student_id', $user->student->id)->get();

        return view('dashboard.student.manage-report', [
            'course' => $course,
            'section' => $section,
            'reports' => $reports
        ]);
    }
}
