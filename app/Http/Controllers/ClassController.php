<?php
namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();

        return view('classes.create', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
        ]);

        ClassModel::create($request->all());

        return redirect()->route('classes.index')->with('success', 'تم إضافة الحصة بنجاح');
    }

    public function index()
    {
        $classes = ClassModel::with('teacher', 'subject')->orderBy('date', 'desc')->paginate(10);

        return view('classes.index', compact('classes'));
    }
}
