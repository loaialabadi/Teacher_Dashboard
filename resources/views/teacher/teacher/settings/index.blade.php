@extends('layouts.teacher')

@section('content')


        <a href="{{ route('teachers.subjects.index', $teacher->id) }}" class="btn btn-warning">
            <i class="fas fa-book"></i> عرض المواد الدراسية
        </a>

        <a href="{{ route('teachers.grades.index', $teacher->id) }}" class="btn btn-info">
            <i class="fas fa-check-circle"></i> عرض الفصول الدراسية
        </a>

@endsection