<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Report;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;


class AdministratorController extends Controller
{
    public function index(): View
    {
        $sections = Section::all();
        return view('dashboard.admin.index', [
            'sections' => $sections
        ]);
    }

    public function viewSection(Request $request, $sectionId): View
    {
        // Retrieve the specific section using the provided sectionId
        $section = Section::where('id', $sectionId)->first();

        // Check if the section was found
        if (!$section) {
            // Handle the case where the section is not found
            return redirect()->back()->with('error', 'Section not found');
        }

        // Pass the retrieved section to the view
        return view('dashboard.admin.view-section', [
            'section' => $section
        ]);
    }


    public function viewStudentAttendance(Request $request, $sectionId, Student $student): View
    {

        $section = $student->section;
        $course = $section->course;
        $attendances = Attendance::where('student_id', $student->id)->get();

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
                $attendance = Attendance::where('student_id', $student->id)
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


        return view('dashboard.admin.view-student-attendance', [
            'student' => $student,
            'attendances' => $attendances,
            'course' => $course,
            'section' => $section,
            'subAttendances' => $subAttendances
        ]);
    }



    public function addStudent(): View
    {
        $sections = Section::all();

        return view('dashboard.admin.add-student', [
            'sections' => $sections
        ]);
    }

    public function addCourse(): View
    {
        return view('dashboard.admin.add-course');
    }

    public function addSection(): View
    {
        $courses = Course::all();
        return view('dashboard.admin.add-section', ['courses' => $courses]);
    }

    public function addSubject(): View
    {
        $courses = Course::all();
        return view('dashboard.admin.add-subject', ['courses' => $courses]);
    }

    public function addReport(): View
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('dashboard.admin.add-report', ['students' => $students, 'subjects' => $subjects]);
    }


    public function addStudentStore(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'section_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        Student::create([
            'user_id' => $user->id, 'section_id' => $request->section_id,
        ]);

        return back()->with('success', 'Student added Successfully');
    }


    public function addCourseStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'fee' => ['required', 'numeric'],
        ]);

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'fee' => $request->fee,
        ]);

        return back()->with('success', 'Course added Successfully');
    }

    public function addSectionStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'string'],
            'end_date' => ['required', 'string'],
            'course_id' => ['required'],
        ]);

        Section::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'course_id' => $request->course_id,
        ]);

        return back()->with('success', 'Section added Successfully');
    }

    public function addSubjectStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:255'],
            'course_id' => ['required'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string']
        ]);

        Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Subject added Successfully');
    }

    public function addReportStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:255'],
            'mark' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],
            'student_id' => ['required'],
            'subject_id' => ['required'],
        ]);

        Report::create([
            'name' => $request->name,
            'description' => $request->description,
            'mark' => $request->mark,
            'status' => $request->status,
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ]);

        return back()->with('success', 'Report added Successfully');
    }


    public function  manageStudent(Request $request): View
    {
        $studentsWithUsers = Student::with('user')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->filter($request->query())
            ->paginate(10);

        // Get the column names for the 'users' table
        // $columns = Schema::getColumnListing('users');
        // Columns to exclude
        //! Must implement dynamically get columns names
        $columnsToExclude = ['id', 'name', 'email', 'phone_number', 'address', 'section_name', 'created_at'];
        $sections = Section::all();

        return view('dashboard.admin.manage-student', [
            'studentsWithUsers' => $studentsWithUsers,
            'columns' => $columnsToExclude,
            'sections' => $sections
        ]);
    }

    public function  manageCourse(Request $request): View
    {
        // $studentsWithUsers = Student::with('user')
        //     ->join('users', 'students.user_id', '=', 'users.id')
        //     ->orderBy('users.created_at', 'desc')
        //     ->get();
        // // Get the column names for the 'users' table
        // // $columns = Schema::getColumnListing('users');
        // // Columns to exclude
        // //! Must implement dynamically get columns names
        $columnsToExclude = ['id', 'name', 'duration', 'description', 'fee', 'created_at'];

        $courses = Course::latest()->filter($request->query())->paginate(10);


        return view('dashboard.admin.manage-course', [
            'columns' => $columnsToExclude,
            'courses' => $courses
        ]);
    }

    public function  manageSection(Request $request): View
    {

        $sections = Section::latest()->filter($request->query())->paginate(10);

        $columnsToExclude = ['id', 'name', 'description', 'course_name', 'start_date', 'end_date', 'total_students', 'created_at'];

        return view('dashboard.admin.manage-section', [
            'columns' => $columnsToExclude,
            'sections' => $sections
        ]);
    }

    public function  manageSubject(Request $request): View
    {

        $subjects = Subject::latest()->filter($request->query())->paginate(10);

        $columnsToExclude = ['id', 'name', 'description', 'course_name', 'start_time', 'end_time', 'created_at'];

        return view('dashboard.admin.manage-subject', [
            'columns' => $columnsToExclude,
            'subjects' => $subjects
        ]);
    }

    public function  manageReport(Request $request): View
    {

        $reports = Report::latest()->filter($request->query())->paginate(10);

        $columnsToExclude = ['id', 'name', 'description', 'mark', 'status', 'student_name', 'subject_name', 'created_at'];

        return view('dashboard.admin.manage-report', [
            'columns' => $columnsToExclude,
            'reports' => $reports
        ]);
    }


    public function manageStudentDelete(Request $request, $studentId): RedirectResponse
    {
        $user = User::find($studentId);

        $user->student->delete();
        $user->delete();

        return back()->with('success', 'Student deleted Successfully');
    }

    public function manageCourseDelete(Request $request, $courseId): RedirectResponse
    {
        $course = Course::where('id', $courseId)->first();

        $course->delete();

        return back()->with('success', 'Course deleted Successfully');
    }

    public function manageSectionDelete(Request $request, $sectionId): RedirectResponse
    {
        $section = Section::where('id', $sectionId)->first();

        $section->delete();

        return back()->with('success', 'Section deleted Successfully');
    }

    public function manageSubjectDelete(Request $request, $subjectId): RedirectResponse
    {
        $subject = Subject::where('id', $subjectId)->first();

        $subject->delete();

        return back()->with('success', 'Subject deleted Successfully');
    }

    public function manageReportDelete(Request $request, $reportId): RedirectResponse
    {
        $report = Report::where('id', $reportId)->first();

        $report->delete();

        return back()->with('success', 'Report deleted Successfully');
    }

    public function updateStudent(Request $request, $studentId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'section_id' => ['required'],
        ]);

        $user = User::find($studentId);

        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        if (isset($request->section_id)) {
            $user->student->update([
                'section_id' => $request->section_id,
            ]);
        }

        return back()->with('success', 'Student updated Successfully');
    }

    public function updateCourse(Request $request, $courseId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'fee' => ['required', 'numeric'],
        ]);

        $course = Course::where('id', $courseId)->first();;

        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'fee' => $request->fee,
        ]);

        return back()->with('success', 'Course updated Successfully');
    }

    public function updateSection(Request $request, $sectionId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'string'],
            'end_date' => ['required', 'string'],
        ]);

        $section = Section::where('id', $sectionId)->first();;

        $section->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Section updated Successfully');
    }


    public function updateSubject(Request $request, $subjectId): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string']
        ]);

        $subject = Subject::where('id', $subjectId)->first();;

        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Subject updated Successfully');
    }

    public function updateReport(Request $request, $reportId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'mark' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $report = Report::where('id', $reportId)->first();;

        $report->update([
            'name' => $request->name,
            'description' => $request->description,
            'mark' => $request->mark,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Report updated Successfully');
    }

    public function resetPassword(Request $request, $studentId): RedirectResponse
    {
        // Find the user by ID
        $user = User::findOrFail($studentId);
        // Update the user's password
        $user->password = Hash::make('password');
        $user->save();
        // Redirect back with success message
        return back()->with('success', 'Password updated successfully.');
    }
}
