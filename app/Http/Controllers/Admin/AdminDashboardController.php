<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
class AdminDashboardController extends Controller
{
public function index()
{
    $studentCount = Student::count();
    $teacherCount = Teacher::count();
    $parentCount  = ParentModel::count();

    return view('admin.dashboard', compact('studentCount', 'teacherCount', 'parentCount'));
}
}
