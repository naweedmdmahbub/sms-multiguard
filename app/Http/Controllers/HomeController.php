<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd(Auth::check(), Auth::guard('student'));
        // $this->middleware(['auth', 'auth:student']);
        // $this->middleware('auth');
        // $this->middleware(['auth']);
        // $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getDashboardData()
    {
        $students = Student::count();
        $departments = Department::count();
        $department_students = Department::withCount('students')->get();
        $semester_students = Semester::withCount('students')->get();
        return [
            'students' => $students,
            'departments' => $departments,
            'department_students' => $department_students,
            'semester_students' => $semester_students,
        ];
    }
}
