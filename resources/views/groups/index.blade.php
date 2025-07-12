@extends('layouts.index')

@section('content')
<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📘 مجموعات المعلم: <span class="text-primary">{{ $teacher->name }}</span></h2>
        <a href="{{ route('groups.create', $teacher->id) }}" class="btn btn-dark">
            <i class="fas fa-plus-circle"></i> إنشاء مجموعة جديدة
        </a>
    </div>

    @forelse ($groups as $group)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">{{ $group->name }}</h5>
                    <small class="text-muted">👥 عدد الطلاب: {{ $group->students->count() }}</small>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('groups.show', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> عرض التفاصيل
                    </a>
                    <a href="{{ route('groups.transferForm', ['teacher' => $teacher->id, 'sourceGroup' => $group->id]) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-random"></i> نقل طلاب
                    </a>
                    <a href="{{ route('groups.add-student', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-user-plus"></i> إضافة طالب
                    </a>
<a href="{{ route('teachers.groups.attendance.index', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-primary">
    <i class="fas fa-user-check"></i> حضور وغياب المجموعة
</a>


                </div>
            </div>
        </div>
        
    @empty
        <div class="alert alert-info text-center">
            لا توجد مجموعات بعد لهذا المعلم.
        </div>
    @endforelse

</div>



@endsection
