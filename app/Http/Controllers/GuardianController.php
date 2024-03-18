<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuardianController extends Controller
{
    public function index(): View
    {
        return view('dashboard.parent.index');
    }

    public function getReport(Request $request): View
    {
        $user = $request->user();

        $section = $user->guardian->student->section;
        $course = $section->course;

        $reports = Report::where('student_id', $user->guardian->student->id)->get();

        return view('dashboard.parent.manage-report', [
            'course' => $course,
            'section' => $section,
            'reports' => $reports
        ]);
    }

    public function getAttendance(Request $request): View
    {
        $user = $request->user();

        $section = $user->guardian->student->section;
        $course = $section->course;
        $attendances = Attendance::where('student_id', $user->guardian->student->id)->get();

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
                $attendance = Attendance::where('student_id', $user->guardian->student->id)
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


        return view('dashboard.parent.manage-attendance', [
            'attendances' => $attendances,
            'course' => $course,
            'section' => $section,
            'subAttendances' => $subAttendances
        ]);
    }
}
