<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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
