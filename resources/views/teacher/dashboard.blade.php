@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">📘 لوحة المعلم: {{ $teacher->name }}</h2>

    <div class="d-flex flex-wrap gap-2 mb-4">

        <a href="{{ route('students.create', $teacher->id) }}" class="btn btn-dark mb-3">
            <i class="fas fa-plus-circle"></i> إضافة طالب جديد
        </a>
        
@isset($group)
    <a href="{{ route('teachers.groups.attendance.index', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-primary">
        <i class="fas fa-user-check"></i> حضور وغياب المجموعة
    </a>
@endisset



        {{-- <a href="{{ route('appointments.create', ['teacher' => $teacher->id, 'group' => $groupId]) }}" class="btn btn-primary">
            <i class="fas fa-calendar-alt"></i> جدول الحصص
        </a> --}}

        <a href="{{ route('teachers.students.index', ['teacher' => $teacher->id]) }}" class="btn btn-primary">
            عرض الطلاب
        </a>

        <a href="{{ route('groups.index', $teacher->id) }}" class="btn btn-success">
            <i class="fas fa-users"></i> عرض المجموعات
        </a>

        <a href="{{ route('subjects.index', $teacher->id) }}" class="btn btn-warning">
            <i class="fas fa-book"></i> عرض المواد الدراسية
        </a>

        <a href="{{ route('grades.index', $teacher->id) }}" class="btn btn-info">
            <i class="fas fa-check-circle"></i> عرض الفصول الدراسية
        </a>

        <a href="{{ route('lectures.index', $teacher->id) }}" class="btn btn-secondary">
            <i class="fas fa-chalkboard-teacher"></i> محاضرات المعلم
        </a>

    </div>

    <div class="mb-4">
        <h3>المجموعات الحالية</h3>
@isset($groups)
    @if($groups->isEmpty())
        <p>لا توجد مجموعات حالياً.</p>
    @else
        <ul class="list-group">
            @foreach($groups as $group)
                <li class="list-group-item">
                    {{ $group->name }}
                </li>
            @endforeach
        </ul>
    @endif
@endisset

    </div>

    <div>
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
@endsection
