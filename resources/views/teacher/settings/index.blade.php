@extends('layouts.index')

@section('content')


        <a href="{{ route('subjects.index', $teacher->id) }}" class="btn btn-warning">
            <i class="fas fa-book"></i> عرض المواد الدراسية
        </a>

        <a href="{{ route('grades.index', $teacher->id) }}" class="btn btn-info">
            <i class="fas fa-check-circle"></i> عرض الفصول الدراسية
        </a>

@endsection