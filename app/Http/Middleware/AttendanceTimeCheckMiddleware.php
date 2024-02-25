<?php

namespace App\Http\Middleware;

use App\Models\Attendance;
use App\Models\Subject;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceTimeCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentTime = Carbon::now()->format('H:i:s');
        $currentDate  = Carbon::now();

        $subject = Subject::find($request->route('subjectId'));

        $latestAttendance = Attendance::where('subject_id', $request->route('subjectId'))
            ->where('student_id', $request->user()->student->id)
            ->latest()
            ->first();

        if ($currentTime >= $subject->start_time && $currentTime <= $subject->end_time) {
            if ($latestAttendance) {
                if ($latestAttendance->created_at->toDateString() === $currentDate->toDateString()) {
                    return back()->with(['error' => 'Attendance is already make.']);
                }
            }
            return $next($request);
        }

        return back()->with(['error' => 'Attendance marking is allowed only during specified time.']);
    }
}
