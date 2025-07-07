@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">📘 لوحة المعلم: {{ $teacher->name }}</h2>

    <div class="d-flex flex-wrap gap-2 mb-4">

<a href="{{ route('students.create', $teacher->id) }}" class="btn btn-dark mb-3">
    <i class="fas fa-plus-circle"></i> إضافة طالب جديد
</a>


{{-- <a href="{{ route('appointments.create', ['teacher' => $teacher->id, 'group' => $groupId]) }}" class="btn btn-primary">...</a> --}}
            {{-- <i class="fas fa-calendar-alt"></i> جدول الحصص
        </a> --}}

        <a href="{{ route('teachers.showstudents', ['teacher' => $teacher->id]) }}" class="btn btn-info">
            <i class="fas fa-users"></i> عرض طلاب المعلم
        </a>

        <a href="{{ route('groups.index', $teacher->id) }}" class="btn btn-success">
            <i class="fas fa-users"></i> عرض المجموعات
        </a>

            <a href="{{ route('teachers.showclasses', $teacher->id) }}" class="btn btn-info">
            <i class="fas fa-check-circle"></i> عرض الفصول الدراسية
        </a>


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