<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
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
        return view('dashboard.admin.add-student');
    }

    public function addCourse(): View
    {
        return view('dashboard.admin.add-course');
    }

    public function addStudentStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        if ($request->type) {
            Student::create([
                'user_id' => $user->id,
            ]);
        }

        return back()->with('success', 'Student Added Successfully');
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

        return back()->with('success', 'Course Added Successfully');
    }

    public function  manageStudent(): View
    {
        $studentsWithUsers = Student::with('user')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->orderBy('users.created_at', 'desc')
            ->get();

        // Get the column names for the 'users' table
        // $columns = Schema::getColumnListing('users');
        // Columns to exclude
        //! Must implement dynamically get columns names
        $columnsToExclude = ['id', 'name', 'email', 'phone_number', 'address', 'created_at'];

        return view('dashboard.admin.manage-student', [
            'studentsWithUsers' => $studentsWithUsers,
            'columns' => $columnsToExclude
        ]);
    }

    public function  manageCourse(): View
    {
        // $studentsWithUsers = Student::with('user')
        //     ->join('users', 'students.user_id', '=', 'users.id')
        //     ->orderBy('users.created_at', 'desc')
        //     ->get();

        // // Get the column names for the 'users' table
        // // $columns = Schema::getColumnListing('users');
        // // Columns to exclude
        // //! Must implement dynamically get columns names
        // $columnsToExclude = ['id', 'name', 'email', 'phone_number', 'address', 'created_at'];

        return view('dashboard.admin.manage-course');
    }

    public function manageStudentDelete(Request $request, $studentId): RedirectResponse
    {
        $user = User::find($studentId);

        $user->student->delete();
        $user->delete();

        return back()->with('success', 'Student Deleted Successfully');
    }

    public function updateStudent(Request $request, $studentId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
            'address' => ['required'],
        ]);

        $user = User::find($studentId);

        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Student Deleted Successfully');
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
