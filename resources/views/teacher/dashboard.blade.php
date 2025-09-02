@extends('layouts.index')

@section('content')
<div class="container my-4">

    {{-- عنوان --}}
    <div class="card shadow-sm mb-4">
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

            <a href="{{ route('groups.index', $teacher->id) }}" class="btn btn-success">
                <i class="fas fa-users"></i> عرض المجموعات
            </a>

            <a href="{{ route('lectures.index', $teacher->id) }}" class="btn btn-secondary">
                <i class="fas fa-chalkboard-teacher"></i> محاضرات المعلم
            </a>

            <a href="{{ route('teacher.settings', $teacher->id) }}" class="btn btn-warning text-dark">
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
                    <ul class="list-group">
                        @foreach($groups as $group)
                            <li class="list-group-item">
                                <i class="fas fa-layer-group text-primary"></i> {{ $group->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endisset
        </div>
    </div>

    {{-- جدول الحصص / إنشاء مجموعة --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if ($groupId)
                <a href="{{ route('appointments.create', ['teacher' => $teacher->id, 'group' => $groupId]) }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i> إنشاء جدول 6 شهور
                </a>
            @else
                <a href="{{ route('groups.create', $teacher->id) }}" class="btn btn-secondary">
                    <i class="fas fa-plus"></i> إنشاء مجموعة أولاً
                </a>
            @endif
        </div>
    </div>

    {{-- تسجيل حضور اليوم --}}
    <div class="text-center">
        <a href="{{ route('teachers.attendance.today', $teacher->id) }}" class="btn btn-lg btn-outline-primary">
            📅 تسجيل حضور اليوم
        </a>
    </div>

</div>
@endsection
