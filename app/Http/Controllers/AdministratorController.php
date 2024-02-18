<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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

    public function  manageStudent(): View
    {
        $studentsWithUsers = Student::with('user')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->orderBy('users.created_at', 'desc')
            ->get();

        // Get the column names for the 'users' table
        $columns = Schema::getColumnListing('users');


        // Columns to exclude
        $columnsToExclude = ['id', 'name', 'email', 'phone_number', 'address', 'created_at'];

        // Filter out the columns to exclude
        $filteredColumns = array_diff($columnsToExclude, $columns);


        return view('dashboard.admin.manage-student', [
            'studentsWithUsers' => $studentsWithUsers,
            'columns' => $columnsToExclude
        ]);
    }
}
