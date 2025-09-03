<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentAllsController extends Controller
{
    public function index()
    {
        $students = Student::with(['parent', 'grade'])->get(); // جلب كل الطلاب مع ولي الأمر والفصل
        return view('students.index', compact('students'));
    }
}
