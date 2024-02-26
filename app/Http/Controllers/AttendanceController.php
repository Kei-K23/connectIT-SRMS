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

        $startDate = Carbon::createFromFormat('m/d/Y', $section->start_date);
        $endDate = Carbon::createFromFormat('m/d/Y', $section->end_date);

        $subjects = $course->subjects;

        // Array to store generated dates
        $subAttendances = [];
        $currentDate = now();
        // Generate dates between start and end dates
        while ($startDate->lte($endDate)) {

            foreach ($subjects as $key => $subject) {

                $asocArr = [];
                $asocArr['date'] = $startDate->format('m/d/Y');
                $asocArr['start_time'] = $subject->start_time;
                $asocArr['end_time'] = $subject->end_time;
                $asocArr['name'] = $subject->name;
                // Fetch attendance status for this subject and date
                $attendance = Attendance::where('student_id', $user->student->id)
                    ->where('subject_id', $subject->id)
                    ->whereDate('created_at', $startDate->format('Y-m-d'))
                    ->first();

                if ($attendance) {
                    $asocArr['status'] = $attendance->is_present ? 'Present' : 'Absent';
                } else {
                    // Check if the date is in the past
                    if ($startDate->lt($currentDate)) {
                        $asocArr['status'] = 'Absent'; // Mark as absent for past dates without attendance
                    } else {
                        $asocArr['status'] = 'Not Recorded';
                    }
                }
                $subAttendances[] = $asocArr;
            }

            $startDate->addDay();
        }


        return view('dashboard.student.manage-attendance', [
            'attendances' => $attendances,
            'course' => $course,
            'section' => $section,
            'subAttendances' => $subAttendances
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
