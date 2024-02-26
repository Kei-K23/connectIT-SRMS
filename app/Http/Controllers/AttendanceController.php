<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{

    public function index(Request $request): View
    {
        $user = $request->user();

        $section = $user->student->section;
        $course = $section->course;
        $attendances = Attendance::where('student_id', $user->student->id)->get();


        return view('dashboard.student.manage-attendance', [
            'attendances' => $attendances,
            'course' => $course,
            'section' => $section
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'is_present' => ['required', 'string'],
            'student_id' => ['required'],
            'section_id' => ['required'],
            'subject_id' => ['required'],
        ]);

        $current_time = Carbon::now()->format('H:i:s');

        Attendance::create([
            'is_present' => $request->is_present === "true" ? true : false,
            'enter_attendance_time' => $current_time,
            'student_id' => $request->student_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
        ]);

        return back()->with('success', 'Attendance make successful');
    }
}
