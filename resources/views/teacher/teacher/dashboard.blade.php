@extends('layouts.index')

@section('content')
<div class="container my-4">

    {{-- عنوان الصفحة --}}
    <div class="card shadow-sm mb-4 border-primary">
        <div class="card-body">
            <h2 class="mb-0">📘 لوحة المعلم: <span class="text-primary">{{ $teacher->name }}</span></h2>
        </div>
    </div>

    {{-- الأزرار الأساسية --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap gap-2">

            <a href="{{ route('students.create', $teacher->id) }}" class="btn btn-dark">
                <i class="fas fa-plus-circle"></i> إضافة طالب جديد
            </a>

            @isset($group)
                <a href="{{ route('teachers.groups.attendance.index', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-primary">
                    <i class="fas fa-user-check"></i> حضور وغياب المجموعة
                </a>
            @endisset

            <a href="{{ route('teachers.students.index', ['teacher' => $teacher->id]) }}" class="btn btn-info text-white">
                <i class="fas fa-user-graduate"></i> عرض الطلاب
            </a>

            <a href="{{ route('teachers.groups.index', ['teacher' => $teacher->id]) }}" class="btn btn-success">
                <i class="fas fa-users"></i> عرض المجموعات
            </a>

            <a href="{{ route('teachers.lectures.index', ['teacher' => $teacher->id]) }}" class="btn btn-secondary">
                <i class="fas fa-chalkboard-teacher"></i> عرض المحاضرات
            </a>

            <a href="{{ route('teachers.teacher.settings', $teacher->id) }}" class="btn btn-warning text-dark">
                <i class="fas fa-cog"></i> إعدادات المعلم
            </a>
        </div>
    </div>

    {{-- المجموعات الحالية --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-3">📋 المجموعات الحالية</h4>
            @isset($groups)
                @if($groups->isEmpty())
                    <p class="text-muted">لا توجد مجموعات حالياً.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($groups as $group)
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-layer-group text-primary me-2"></i>
                                {{ $group->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endisset
        </div>
    </div>

</div>
@endsection
