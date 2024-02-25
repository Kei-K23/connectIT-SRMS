<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Report;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;


class AdministratorController extends Controller
{
    public function index(): View
    {
        return view('dashboard.admin.index');
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
        return view('dashboard.admin.add-report', ['students' => $students]);
    }


    public function addStudentStore(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
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
            'name' => ['required', 'string', 'max:255'],
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
            'name' => ['required', 'string', 'max:255'],
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'course_id' => ['required'],
        ]);

        Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $request->course_id,
        ]);

        return back()->with('success', 'Subject added Successfully');
    }

    public function addReportStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'mark' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],
            'student_id' => ['required'],
        ]);

        Report::create([
            'name' => $request->name,
            'description' => $request->description,
            'mark' => $request->mark,
            'status' => $request->status,
            'student_id' => $request->student_id,
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

        $columnsToExclude = ['id', 'name', 'description', 'course_name', 'created_at'];

        return view('dashboard.admin.manage-subject', [
            'columns' => $columnsToExclude,
            'subjects' => $subjects
        ]);
    }

    public function  manageReport(Request $request): View
    {

        $reports = Report::latest()->filter($request->query())->paginate(10);

        $columnsToExclude = ['id', 'name', 'description', 'mark', 'status', 'student_name', 'created_at'];

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
        ]);

        $subject = Subject::where('id', $subjectId)->first();;

        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
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
